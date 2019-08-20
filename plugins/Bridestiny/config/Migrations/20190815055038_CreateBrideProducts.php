<?php
use Migrations\AbstractMigration;

class CreateBrideProducts extends AbstractMigration
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
        $table = $this->table('bride_products');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('thumbnail', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('images', 'string', [
            'default' => null,
            'limit'   => 500,
            'null'    => false
        ]);
        $table->addColumn('base_price', 'integer', [
            'default' => null,
            'limit'   => 11,
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
            'limit'   => 50,
            'null'    => false,
        ]);
        $table->addColumn('category_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('vendor_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addIndex(['category_id']);
        $table->addForeignKey('category_id', 'bride_categories', 'id');
        $table->addIndex(['vendor_id']);
        $table->addForeignKey('vendor_id', 'bride_vendors', 'id');
        $table->create();
    }
}
