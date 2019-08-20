<?php
use Migrations\AbstractMigration;

class CreateBrideCoupons extends AbstractMigration
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
        $table = $this->table('bride_coupons');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('description', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('term_and_condition', 'text', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('minimal_transaction', 'integer', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('maximal_transaction', 'integer', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('active_date', 'date', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('expire_date', 'date', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => false,
        ]);
        $table->addColumn('discount_type', 'string', [
            'default' => null,
            'limit' => 25,
            'null' => false,
        ]);
        $table->addColumn('discount_value', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('max_discount', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->create();
    }
}
