<?php
use Migrations\AbstractMigration;

class CreateBrideSettings extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('bride_settings');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false,
        ]);
        $table->addColumn('value', 'text', [
            'default' => null,
            'null'    => false,
        ]);
        $table->create();
    }
}
