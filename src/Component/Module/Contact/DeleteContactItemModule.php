<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractDeleteItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapper;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapperQuery;

class DeleteContactItemModule extends AbstractDeleteItemModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactMapper($connection);
    }

    protected function forgeMapperQuery(): ?MapperQueryInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactMapperQuery($connection);
    }
}
