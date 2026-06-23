<?php
namespace Pyncer\Snyppet\Contact\Table\Contact;

use Pyncer\Data\MapperQuery\AbstractRequestMapperQuery;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Database\Record\SelectQueryInterface;

class ContactMapperQuery extends AbstractRequestMapperQuery
{
    public function overrideModel(
        ModelInterface $model,
        array $data
    ): ModelInterface
    {
        if ($this->getOptions() === null) {
            return $model;
        }

        if ($this->getOptions()->hasOption('include-profile-status')) {
            $total = intval($data['total_items']);
            $pending = intval($data['pending_items']);
            $enabled = intval($data['enabled_items']);

            $model->addExtraData([
                'profile_status' => [
                    'total' => $total,
                    'pending' => $pending,
                    'enabled' => $enabled,
                    'disabled' => $total - $pending - $enabled,
                ]
            ]);
        }

        return $model;
    }

    protected function isValidFilter(
        string $left,
        mixed $right,
        string $operator,
    ): bool
    {
        if ($left === 'uid' &&
            is_string($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        if ($left === 'verify' &&
            is_bool($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        if ($left === 'private' &&
            is_bool($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        if ($left === 'enabled' &&
            is_bool($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        if ($left === 'deleted' &&
            is_bool($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        if ($left === 'alias' &&
            is_string($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        return parent::isValidFilter($left, $right, $operator);
    }

    protected function isValidOption(string $option): bool
    {
        switch ($option) {
            case 'include-profile-status':
                return true;
        }

        return parent::isValidOption($option);
    }

    protected function applyOption(
        SelectQueryInterface $query,
        string $option
    ): SelectQueryInterface
    {
        if ($option === 'include-profile-status') {
            $query->leftJoinOn(
                'contact__profile',
                [
                    ['contact_id', 'id'],
                ]
            );

            $totalCountFunction = $this->getConnection()->functions('contact__profile', 'Count')
                ->arguments(['contact__profile', 'id']);

            $pendingCaseFunction = $this->getConnection()->functions('contact__profile', 'Case')
                ->when([
                    'pending' => true,
                    'enabled' => false,
                ])
                ->then(1);

            $pendingCountFunction = $this->getConnection()->functions('contact__profile', 'Count')
                ->arguments($pendingCaseFunction);

            $enabledCaseFunction = $this->getConnection()->functions('contact__profile', 'Case')
                ->when([
                    'pending' => false,
                    'enabled' => true,
                ])
                ->then(1);

            $enabledCountFunction = $this->getConnection()->functions('contact__profile', 'Count')
                ->arguments($enabledCaseFunction);

            $query->columns(
                    [$totalCountFunction, 'total_items'],
                    [$pendingCountFunction, 'pending_items'],
                    [$enabledCountFunction, 'enabled_items'],
                )
                ->groupBy('id');

            return $query;
        }

        return parent::applyOption($query, $option);
    }

    protected function isValidOrderBy(string $key, string $direction): bool
    {
        switch ($key) {
            case 'name':
            case 'alias':
            case 'enabled':
            case 'insert_date_time':
            case 'update_date_time':
                return true;
        }

       return parent::isValidOrderBy($key, $direction);
    }

    protected function getOrderByColumn(
        SelectQueryInterface $query,
        string $key,
        string $direction
    ): array
    {
        switch ($key) {
            case 'update_date_time':
                $function = $this->getConnection()->functions(
                    'contact',
                    'Coalesce'
                )->arguments('update_date_time', 'insert_date_time');
                return [$function, $direction];
        }

        return parent::getOrderByColumn($query, $key, $direction);
    }
}
