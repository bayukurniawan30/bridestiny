<?php
use Migrations\AbstractMigration;

class CreateBrideWishlists extends AbstractMigration
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
        $table = $this->table('bride_wishlists');
        $table->addColumn('created', 'datetime', [
            'default' => null,
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
        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'bride_customers', 'id');
        $table->addIndex(['vendor_id']);
        $table->addForeignKey('vendor_id', 'bride_vendors', 'id');
        $table->create();
    }
}
