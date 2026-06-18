<?php
namespace Pyncer\Snyppet\Contact\Table\Contact;

use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactModel;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapperQuery;

class ContactMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'contact';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new ContactModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof ContactModel);
    }

    public function isValidMapperQuery(MapperQueryInterface $mapperQuery): bool
    {
        return ($mapperQuery instanceof ContactMapperQuery);
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
