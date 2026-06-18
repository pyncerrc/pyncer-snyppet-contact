<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileModel;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileMapperQuery;

class ProfileMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'contact__profile';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new ProfileModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof ProfileModel);
    }

    public function isValidMapperQuery(MapperQueryInterface $mapperQuery): bool
    {
        return ($mapperQuery instanceof ProfileMapperQuery);
    }

    public function selectByUid(
        string $uid,
        ?MapperQueryInterface $mapperQuery = null,
    ): ?ModelInterface
    {
        return $this->selectByColumns(
            [
                'uid' => $uid,
            ],
            $mapperQuery
        );
    }
}
