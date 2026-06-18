<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractGetIndexModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapper;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapperQuery;
use Pyncer\Snyppet\Contact\Table\Contact\ContactModel;

class GetContactIndexModule extends AbstractGetIndexModule
{
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
}
