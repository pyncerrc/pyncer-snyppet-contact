<?php
namespace Pyncer\Snyppet\Contact\Install;

use Pyncer\Database\Table\Column\IntSize;
use Pyncer\Database\Table\Column\TextSize;
use Pyncer\Database\Table\ReferentialAction;
use Pyncer\Database\Value;
use Pyncer\Snyppet\AbstractInstall;

class Install extends AbstractInstall
{
    protected function safeInstall(): bool
    {
        $this->connection->createTable('contact')
            ->serial('id')
            ->char('uid', 36)->index()
            ->string('mark', 250)->null()->index()
            ->dateTime('insert_date_time')->default(Value::NOW)->index()
            ->dateTime('update_date_time')->null()->index()
            ->string('name', 50)->null()->index()
            ->string('alias', 50)->null()->index()
            ->bool('verify')->default(false)->index()
            ->bool('private')->default(false)->index()
            ->bool('enabled')->default(false)->index()
            ->bool('deleted')->default(false)->index()
            ->index('#unique', 'uid')->unique()
            ->execute();

        $this->connection->createTable('contact__profile')
            ->serial('id')
            ->char('uid', 36)->index()
            ->int('contact_id', IntSize::BIG)->index()
            ->string('mark', 250)->null()->index()
            ->dateTime('insert_date_time')->default(Value::NOW)->index()
            ->dateTime('update_date_time')->null()->index()
            ->string('name', 50)->null()->index()
            ->string('email', 125)->null()->index()
            ->string('phone', 25)->null()->index()
            ->bool('pending')->default(false)->index()
            ->bool('enabled')->default(false)->index()
            ->index('#unique', 'uid')->unique()
            ->foreignKey(null, 'contact_id')
                ->references('contact', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->execute();

        $this->connection->createTable('contact__profile__data')
            ->serial('id')
            ->int('contact_profile_id', IntSize::BIG)->index()
            ->string('key', 50)->index()
            ->string('type', 125)->index()
            ->text('value', TextSize::MEDIUM)
            ->index('#unique', 'contact_profile_id', 'key')->unique()
            ->foreignKey(null, 'contact_profile_id')
                ->references('contact__profile', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->execute();

        $this->connection->createTable('contact__profile__value')
            ->serial('id')
            ->int('contact_profile_id', IntSize::BIG)->index()
            ->string('key', 50)->index()
            ->string('value', 250)
            ->bool('preload')->default(false)->index()
            ->index('#unique', 'contact_profile_id', 'key')->unique()
            ->foreignKey(null, 'contact_profile_id')
                ->references('contact__profile', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->execute();

        return true;
    }

    protected function safeUninstall(): bool
    {
        if ($this->connection->hasTable('contact__profile__value')) {
            $this->connection->dropTable('contact__profile__value');
        }

        if ($this->connection->hasTable('contact__profile__data')) {
            $this->connection->dropTable('contact__profile__data');
        }

        if ($this->connection->hasTable('contact__profile')) {
            $this->connection->dropTable('contact__profile');
        }

        if ($this->connection->hasTable('contact')) {
            $this->connection->dropTable('contact');
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function hasRelated(string $snyppetAlias): bool
    {
        switch ($snyppetAlias) {
            case 'organization':
                return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function safeInstallRelated(string $snyppetAlias): bool
    {
        switch ($snyppetAlias) {
            case 'organization':
                return $this->installOrganization();
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function safeUninstallRelated(string $snyppetAlias): bool
    {
        switch ($snyppetAlias) {
            case 'organization':
                return $this->uninstallOrganization();
        }

        return false;
    }

    protected function installOrganization(): bool
    {
        $this->connection->createTable('contact__organization')
            ->serial('id')
            ->int('contact_id', IntSize::BIG)->index()
            ->int('organization_id', IntSize::BIG)->index()
            ->index('#unique', 'contact_id')->unique()
            ->foreignKey(null, 'contact_id')
                ->references('contact', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->foreignKey(null, 'organization_id')
                ->references('organization', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->execute();

        return true;
    }

    protected function uninstallOrganization(): bool
    {
        if ($this->connection->hasTable('contact__organization')) {
            $this->connection->dropTable('contact__organization');
        }

        return true;
    }
}
