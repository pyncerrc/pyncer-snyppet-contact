<?php
namespace Pyncer\Snyppet\Contact\Table\Contact;

use Pyncer\Data\Validation\AbstractValidator;
use Pyncer\Database\ConnectionInterface;
use Pyncer\Validation\Rule\BoolRule;
use Pyncer\Validation\Rule\IdRule;
use Pyncer\Validation\Rule\IntRule;
use Pyncer\Validation\Rule\DateTimeRule;
use Pyncer\Validation\Rule\RequiredRule;
use Pyncer\Validation\Rule\StringRule;
use Pyncer\Validation\Rule\UidRule;

class ContactValidator extends AbstractValidator
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
            new RequiredRule(),
            new StringRule(
                maxLength: 50,
            ),
        );

        $this->addRules(
            'alias',
            new StringRule(
                maxLength: 50,
                allowNull: true,
            ),
        );

        $this->addRules(
            'verify',
            new BoolRule(),
        );

        $this->addRules(
            'private',
            new BoolRule(),
        );

        $this->addRules(
            'enabled',
            new BoolRule(),
        );

        $this->addRules(
            'deleted',
            new BoolRule(),
        );
    }
}
