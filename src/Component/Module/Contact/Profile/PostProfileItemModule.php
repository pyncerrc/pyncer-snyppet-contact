<?php
namespace Pyncer\Snyppet\Contact\Component\Module\Contact\Profile;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractPostItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\Model\ModelInterface;
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

    protected function getResponseItemData(ModelInterface $model): array
    {
        $data = parent::getResponseItemData($model);

        if (array_key_exists('contact_uid', $data) &&
            $data['contact_uid'] === null
        ) {
            $connection = $this->get(ID::DATABASE);
            $data['contact_uid'] = $connection->select('contact')
                ->columns('uid')
                ->where([
                    'id' => $model->getContactId(),
                ])
                ->value();
        }

        return $data;
    }
}
