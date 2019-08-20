<?php
use Migrations\AbstractMigration;

class CreateBrideCurrencies extends AbstractMigration
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
        $table = $this->table('bride_currencies');
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit'   => 3,
            'null'    => false
        ]);
        $table->addColumn('ordering', 'integer', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null'    => true
        ]);
        $table->create();
    }
}
