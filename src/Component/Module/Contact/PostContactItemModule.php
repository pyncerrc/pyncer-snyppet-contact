<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractPostItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\Validation\ValidatorInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapper;
use Pyncer\Snyppet\Contact\Table\Contact\ContactValidator;

class PostContactItemModule extends AbstractPostItemModule
{
    protected function forgeValidator(): ?ValidatorInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactValidator($connection);
    }

    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactMapper($connection);
    }
}
