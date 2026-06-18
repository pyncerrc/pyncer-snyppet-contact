<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use Pyncer\Data\Model\AbstractModel;

class DataModel extends AbstractModel
{
    public function getContactProfileId(): int
    {
        return $this->get('contact_profile_id');
    }
    public function setContactProfileId(int $value): static
    {
        $this->set('contact_profile_id', $value);
        return $this;
    }

    public function getKey(): string
    {
        return $this->get('key');
    }
    public function setKey(string $value): static
    {
        $this->set('key', $value);
        return $this;
    }

    public function getType(): string
    {
        return $this->get('type');
    }
    public function setType(string $value): static
    {
        $this->set('type', $value);
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->get('value');
    }
    public function setValue(?string $value): static
    {
        $this->set('value', $this->nullify($value));
        return $this;
    }

    public static function getDefaultData(): array
    {
        return [
            'id' => 0,
            'contact_profile_id' => 0,
            'key' => '',
            'type' => '',
            'value' => null,
        ];
    }
}
