<?php
use Migrations\AbstractMigration;

class CreateBrideInspirations extends AbstractMigration
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
        $table = $this->table('bride_inspirations');
        $table->addColumn('photo', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('note', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => true
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit'   => 50,
            'null'    => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'bride_customers', 'id');
        $table->create();
    }
}
