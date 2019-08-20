<?php
use Migrations\AbstractMigration;

class CreateBrideCategories extends AbstractMigration
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
        $table = $this->table('bride_categories');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null'    => false
        ]);
        $table->addColumn('image', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => true
        ]);
        $table->addColumn('icon', 'string', [
            'default' => null,
            'limit'   => 100,
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
        $table->addColumn('parent', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => true
        ]);
        $table->create();
    }
}
