<?php
use Migrations\AbstractMigration;

class CreateBrideProductDiscounts extends AbstractMigration
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
        $table = $this->table('bride_product_discounts');
        $table->addColumn('value', 'integer', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('discount_type', 'string', [
            'default' => null,
            'limit' => 25,
            'null' => false,
        ]);
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addIndex(['product_id']);
        $table->addForeignKey('product_id', 'bride_products', 'id');
        $table->create();
    }
}
