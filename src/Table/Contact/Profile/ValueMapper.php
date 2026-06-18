<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Data\Mapper\MapperResultInterface;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ValueModel;

class ValueMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'contact__profile__value';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new ValueModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof ValueModel);
    }

    public function selectAllPreloaded(
        int $contactProfileId,
        ?MapperQueryInterface $mapperQuery = null
    ): MapperResultInterface
    {
        return $this->selectAllByColumns(
            [
                'contact_profile_id' => $contactProfileId,
                'preload' => true
            ],
            $mapperQuery
        );
    }

    public function selectByKey(
        int $contactProfileId,
        string $key,
        ?MapperQueryInterface $mapperQuery = null
    ): ?ModelInterface
    {
        return $this->selectByColumns(
            [
                'contact_profile_id' => $contactProfileId,
                'key' => $key,
            ],
            $mapperQuery,
        );
    }

    public function selectAllByKeys(
        int $contactProfileId,
        array $keys,
        ?MapperQueryInterface $mapperQuery = null
    ): MapperResultInterface
    {
        return $this->selectAllByColumns(
            [
                'contact_profile_id' => $contactProfileId,
                'key' => $keys,
            ],
            $mapperQuery,
        );
    }
}
