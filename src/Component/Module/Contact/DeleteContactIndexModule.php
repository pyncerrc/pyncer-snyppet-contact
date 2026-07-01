<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractDeleteIndexModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapper;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapperQuery;
use Pyncer\Snyppet\Utility\Component\SoftDeleteTrait;

class DeleteContactItemModule extends AbstractDeleteIndexModule
{
    use SoftDeleteTrait;

    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactMapper($connection);
    }

    protected function forgeMapperQuery(): ?MapperQueryInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactMapperQuery($connection, $this->request);
    }

    protected function deleteItem(ModelInterface $model): array
    {
        if (!$this->getSoftDelete()) {
            return parent::deleteItem($model);
        }

        $errors = [];

        try {
            $mapper = $this->forgeMapper();
            $model->setDeleted(true);
            $mapper->update($model);
        } catch (QueryException) {
            $errors['general'] = 'delete';
        }

        return $errors;
    }
}
