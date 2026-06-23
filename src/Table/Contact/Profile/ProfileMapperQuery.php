<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use Pyncer\Data\MapperQuery\AbstractRequestMapperQuery;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Database\Record\SelectQueryInterface;

use function Pyncer\Array\unset_keys as pyncer_array_unset_keys;

class ProfileMapperQuery extends AbstractRequestMapperQuery
{
    public function overrideModel(
        ModelInterface $model,
        array $data,
    ): ModelInterface
    {
        if (!$this->getOptions()) {
            return $model;
        }

        if ($this->getOptions()->hasOption('include-contact-profile-values')) {
            $result = $this->getConnection()->select('contact__profile__value')
                ->columns('key', 'value')
                ->where(['contact_profile_id' => $model->getId()])
                ->result();

            $extraData = [];
            foreach ($result as $row) {
                $extraData[$row['key']] = $row['value'];
            }

            $extraData = pyncer_array_unset_keys($extraData, $model->getKeys());
            $model->addExtraData($extraData);
        }

        if ($this->getOptions()->hasOption('include-contact-profile-data')) {
            $result = $this->getConnection()->select('contact__profile__data')
                ->columns('key', 'type', 'value')
                ->where(['contact_profile_id' => $model->getId()])
                ->result();

            $extraData = [];
            foreach ($result as $row) {
                $extraData[$row['key']] = [
                    'type' => $row['type'],
                    'value' => $row['value'],
                ];
            }

            $extraData = pyncer_array_unset_keys($extraData, $model->getKeys());
            $model->addExtraData($extraData);
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

        if ($left === 'contact_id' &&
            is_int($right) &&
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

        if ($left === 'pending' &&
            is_bool($right) &&
            ($operator === '=' || $operator === '!=')
        ) {
            return true;
        }

        return parent::isValidFilter($left, $right, $operator);
    }

    protected function applyFilter(
        SelectQueryInterface $query,
        string $left,
        mixed $right,
        string $operator
    ): SelectQueryInterface
    {
        return parent::applyFilter($query, $left, $right, $operator);
    }

    protected function isValidOption(string $option): bool
    {
        switch ($option) {
            case 'include-contact-profile-data':
            case 'include-contact-profile-values':
                return true;
        }

        return parent::isValidOption($option);
    }

    protected function isValidOrderBy(string $key, string $direction): bool
    {
        switch ($key) {
            case 'name':
            case 'email':
            case 'phone':
            case 'enabled':
            case 'pending':
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
                    'contact__profile',
                    'Coalesce'
                )->arguments('update_date_time', 'insert_date_time');
                return [$function, $direction];
        }

        return parent::getOrderByColumn($query, $key, $direction);
    }
}
