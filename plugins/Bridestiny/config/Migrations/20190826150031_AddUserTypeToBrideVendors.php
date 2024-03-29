<?php
use Migrations\AbstractMigration;

class AddUserTypeToBrideVendors extends AbstractMigration
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
        $table = $this->table('bride_vendors');
        $table->addColumn('user_type', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true,
        ]);
        $table->update();
    }
}
