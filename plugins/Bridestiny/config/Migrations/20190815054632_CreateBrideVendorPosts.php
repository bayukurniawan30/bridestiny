<?php
use Migrations\AbstractMigration;

class CreateBrideVendorPosts extends AbstractMigration
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
        $table = $this->table('bride_vendor_posts');
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('content', 'text', [
            'default' => null,
            'null'    => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null'    => true
        ]);
        $table->addColumn('featured', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('comment', 'string', [
            'default' => null,
            'limit'   => 3,
            'null'    => false
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit'   => 50,
            'null'    => false,
        ]);
        $table->addColumn('meta_keywords', 'string', [
            'default' => null,
            'limit'   => 200,
            'null'    => true,
        ]);
        $table->addColumn('meta_description', 'text', [
            'default' => null,
            'null'    => true,
        ]);
        $table->addColumn('social_share', 'string', [
            'default' => null,
            'limit'   => 10,
            'null'    => false,
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
