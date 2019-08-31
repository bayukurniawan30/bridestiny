<?php
use Migrations\AbstractMigration;

class CreateBrideAuth extends AbstractMigration
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
        $table = $this->table('bride_auth');
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('user_type', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => false,
        ]);
        $table->addIndex(['email'], [
            'unique' => true
        ]);
        $table->create();
    }
}
