<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use DateTime;
use DateTimeInterface;
use Pyncer\Data\Model\AbstractModel;

use function Pyncer\uid as pyncer_uid;
use function Pyncer\date_time as pyncer_date_time;

use const Pyncer\DATE_TIME_FORMAT as PYNCER_DATE_TIME_FORMAT;

class ProfileModel extends AbstractModel
{
    public function getUid(): string
    {
        return $this->get('uid');
    }
    public function setUid(string $value): static
    {
        $this->set('uid', $value);
        return $this;
    }

    public function getContactId(): int
    {
        return $this->get('contact_id');
    }
    public function setContactId(int $value): static
    {
        $this->set('contact_id', $value);
        return $this;
    }

    public function getMark(): ?string
    {
        return $this->get('mark');
    }
    public function setMark(?string $value): static
    {
        $this->set('mark', $this->nullify($value));
        return $this;
    }

    public function getInsertDateTime(): DateTime
    {
        $value = $this->get('insert_date_time');
        return pyncer_date_time($value);
    }
    public function setInsertDateTime(string|DateTimeInterface $value): static
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format(PYNCER_DATE_TIME_FORMAT);
        }
        $this->set('insert_date_time', $value);
        return $this;
    }

    public function getUpdateDateTime(): ?DateTime
    {
        $value = $this->get('update_date_time');
        return pyncer_date_time($value);
    }
    public function setUpdateDateTime(null|string|DateTimeInterface $value): static
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format(PYNCER_DATE_TIME_FORMAT);
        }
        $this->set('update_date_time', $this->nullify($value));
        return $this;
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }
    public function setName(?string $value): static
    {
        $this->set('name', $this->nullify($value));
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->get('email');
    }
    public function setEmail(?string $value): static
    {
        $this->set('email', $this->nullify($value));
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->get('phone');
    }
    public function setPhone(?string $value): static
    {
        $this->set('phone', $this->nullify($value));
        return $this;
    }

    public function getEmailVerified(): bool
    {
        return $this->get('email_verified');
    }
    public function setEmailVerified(bool $value): static
    {
        $this->set('email_verified', $value);
        return $this;
    }

    public function getPhoneVerified(): bool
    {
        return $this->get('phone_verified');
    }
    public function setPhoneVerified(bool $value): static
    {
        $this->set('phone_verified', $value);
        return $this;
    }

    public function getPending(): bool
    {
        return $this->get('pending');
    }
    public function setPending(bool $value): static
    {
        $this->set('pending', $value);
        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->get('enabled');
    }
    public function setEnabled(bool $value): static
    {
        $this->set('enabled', $value);
        return $this;
    }

    public static function getDefaultData(): array
    {
        $dateTime = pyncer_date_time()->format(PYNCER_DATE_TIME_FORMAT);

        return [
            'id' => 0,
            'uid' => pyncer_uid(),
            'contact_id' => 0,
            'mark' => null,
            'insert_date_time' => $dateTime,
            'update_date_time' => null,
            'name' => null,
            'email' => null,
            'phone' => null,
            'email_verified' => false,
            'phone_verified' => false,
            'pending' => false,
            'enabled' => true,
        ];
    }
}
