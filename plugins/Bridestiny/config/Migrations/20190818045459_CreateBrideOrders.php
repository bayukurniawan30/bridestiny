<?php
use Migrations\AbstractMigration;

class CreateBrideOrders extends AbstractMigration
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
        $table = $this->table('bride_orders');
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('total_payment', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => false,
        ]);
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('vendor_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('coupon_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addIndex(['product_id']);
        $table->addForeignKey('product_id', 'bride_products', 'id');
        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'bride_customers', 'id');
        $table->addIndex(['vendor_id']);
        $table->addForeignKey('vendor_id', 'bride_vendors', 'id');
        $table->addIndex(['coupon_id']);
        $table->addForeignKey('coupon_id', 'bride_coupons', 'id');
        $table->create();
    }
}
