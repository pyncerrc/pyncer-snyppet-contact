<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractPatchItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Data\Validation\ValidatorInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapper;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapperQuery;
use Pyncer\Snyppet\Contact\Table\Contact\ContactValidator;

use function Pyncer\date_time as pyncer_date_time;

class PatchContactItemModule extends AbstractPatchItemModule
{
    protected function getRequiredItemData(): array
    {
        $data = parent::getRequiredItemData();

        $data['update_date_time'] = pyncer_date_time();

        return $data;
    }

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

    protected function forgeMapperQuery(): ?MapperQueryInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new ContactMapperQuery($connection);
    }
}
