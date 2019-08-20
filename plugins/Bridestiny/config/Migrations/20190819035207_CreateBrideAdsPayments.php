<?php
use Migrations\AbstractMigration;

class CreateBrideAdsPayments extends AbstractMigration
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
        $table = $this->table('bride_ads_payments');
        $table->addColumn('payment_method', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('total', 'integer', [
            'default' => null,
            'limit'   => 11,
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
        $table->addColumn('vendor_ads_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addIndex(['vendor_ads_id']);
        $table->addForeignKey('vendor_ads_id', 'bride_vendor_ads', 'id');
        $table->create();
    }
}
