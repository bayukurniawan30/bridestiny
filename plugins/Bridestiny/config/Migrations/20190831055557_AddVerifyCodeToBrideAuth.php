<?php
use Migrations\AbstractMigration;

class AddVerifyCodeToBrideAuth extends AbstractMigration
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
        $table = $this->table('bride_auth');
        $table->addColumn('verify_code', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => true,
        ]);
        $table->update();
    }
}
