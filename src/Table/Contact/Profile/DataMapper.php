<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Data\Mapper\MapperResultInterface;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\DataModel;

class DataMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'contact__profile__data';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new DataModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof DataModel);
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
