<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact\Profile;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractGetIndexModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileMapper;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileMapperQuery;
use Pyncer\Snyppet\Contact\Table\Contact\Profile\ProfileModel;

class GetProfileIndexModule extends AbstractGetIndexModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ProfileMapper($connection);
    }

    protected function forgeMapperQuery(): ?MapperQueryInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ProfileMapperQuery($connection, $this->request);
    }
}
