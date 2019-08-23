<?php
use Migrations\AbstractMigration;

class AddDeclineDateToBrideVendors extends AbstractMigration
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
        $table = $this->table('bride_vendors');
        $table->addColumn('decline_date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
