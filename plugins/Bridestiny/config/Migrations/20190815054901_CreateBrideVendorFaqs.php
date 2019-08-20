<?php
use Migrations\AbstractMigration;

class CreateBrideVendorFaqs extends AbstractMigration
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
        $table = $this->table('bride_vendor_faqs');
        $table->addColumn('ask', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('answer', 'text', [
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
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit'   => 50,
            'null'    => false,
        ]);
        $table->addColumn('ordering', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => true,
        ]);
        $table->addColumn('vendor_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addIndex(['vendor_id']);
        $table->addForeignKey('vendor_id', 'bride_vendors', 'id');
        $table->create();
    }
}
