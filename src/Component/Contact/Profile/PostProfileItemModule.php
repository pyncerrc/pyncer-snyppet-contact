<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact\Profile;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractPostItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\Validation\ValidatorInterface;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileMapper;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileValidator;

class PostProfileItemModule extends AbstractPostItemModule
{
    protected function forgeValidator(): ?ValidatorInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ProfileValidator($connection);
    }

    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ProfileMapper($connection);
    }
}
