<?php
use Migrations\AbstractMigration;

class AddCodeToBrideVendorAds extends AbstractMigration
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
        $table = $this->table('bride_vendor_ads');
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->update();
    }
}
