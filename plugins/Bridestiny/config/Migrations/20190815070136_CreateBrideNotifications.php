<?php
use Migrations\AbstractMigration;

class CreateBrideNotifications extends AbstractMigration
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
        $table = $this->table('bride_notifications');
        $table->addColumn('type', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('content', 'string', [
            'default' => null,
            'limit'   => 500,
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
        $table->addColumn('is_read', 'integer', [
            'default' => null,
            'limit'   => 1,
            'null'    => false
        ]);
        $table->addColumn('relation_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => NULL
        ]);
        $table->create();
    }
}
