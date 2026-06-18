<?php
namespace Pyncer\Snyppet\Contact\Table\Contact\Profile;

use Pyncer\Data\Validation\AbstractValidator;
use Pyncer\Database\ConnectionInterface;
use Pyncer\Snyppet\Contact\Table\Contact\ContactMapper;
use Pyncer\Validation\Rule\BoolRule;
use Pyncer\Validation\Rule\DateTimeRule;
use Pyncer\Validation\Rule\EmailRule;
use Pyncer\Validation\Rule\PhoneRule;
use Pyncer\Validation\Rule\RequiredRule;
use Pyncer\Validation\Rule\StringRule;
use Pyncer\Validation\Rule\UidRule;

use const Pyncer\Snyppet\Contact\PROFILE_PHONE_ALLOW_E164 as PYNCER_CONTACT_PROFILE_PHONE_ALLOW_E164;
use const Pyncer\Snyppet\Contact\PROFILE_PHONE_ALLOW_NANP as PYNCER_CONTACT_PROFILE_PHONE_ALLOW_NANP;
use const Pyncer\Snyppet\Contact\PROFILE_PHONE_ALLOW_FORMATTING as PYNCER_CONTACT_PROFILE_PHONE_ALLOW_FORMATTING;

class ProfileValidator extends AbstractValidator
{
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct($connection);

        $this->addRules(
            'uid',
            new RequiredRule(UidRule::EMPTY),
            new UidRule(),
            new StringRule(
                maxLength: 36,
            ),
        );

        $this->addRules(
            'contact_id',
            new RequiredRule(IntRule::EMPTY),
            new IntRule(
                minValue: 0,
            ),
            new IdRule(
                mapper: new ContactMapper($this->getConnection()),
            ),
        );

        $this->addRules(
            'mark',
            new StringRule(
                maxLength: 250,
                allowNull: true,
            ),
        );

        $this->addRules(
            'insert_date_time',
            new RequiredRule(DateTimeRule::EMPTY),
            new DateTimeRule(),
        );

        $this->addRules(
            'update_date_time',
            new DateTimeRule(
                allowNull: true
            ),
        );

        $this->addRules(
            'name',
            new StringRule(
                maxLength: 50,
                allowNull: true,
            ),
        );

        $this->addRules(
            'email',
            new EmailRule(),
            new StringRule(
                maxLength: 125,
                allowNull: true,
            ),
        );

        $this->addRules(
            'phone',
            new PhoneRule(
                allowNanp: PYNCER_CONTACT_PROFILE_PHONE_ALLOW_NANP,
                allowE164: PYNCER_CONTACT_PROFILE_PHONE_ALLOW_E164,
                allowFormatting: PYNCER_CONTACT_PROFILE_PHONE_ALLOW_FORMATTING,
            ),
            new StringRule(
                maxLength: 25,
                allowNull: true,
            ),
        );

        $this->addRules(
            'pending',
            new BoolRule(),
        );

        $this->addRules(
            'enabled',
            new BoolRule(),
        );
    }
}
