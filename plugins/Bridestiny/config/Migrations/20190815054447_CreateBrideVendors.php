<?php
use Migrations\AbstractMigration;

class CreateBrideVendors extends AbstractMigration
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
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => true
        ]);
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('phone', 'string', [
            'default' => null,
            'limit'   => 15,
            'null'    => false
        ]);
        $table->addColumn('photo', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => true
        ]);
        $table->addColumn('banner', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => true
        ]);
        $table->addColumn('ktp', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('npwp', 'string', [
            'default' => null,
            'limit'   => 100,
            'null'    => false
        ]);
        $table->addColumn('facebook', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => true
        ]);
        $table->addColumn('instagram', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => true
        ]);
        $table->addColumn('province', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('city', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => false
        ]);
        $table->addColumn('token', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false
        ]);
        $table->addColumn('login_device', 'string', [
            'default' => null,
            'limit'   => 50,
            'null'    => true
        ]);
        $table->addColumn('login_os', 'string', [
            'default' => null,
            'limit'   => 50,
            'null'    => true
        ]);
        $table->addColumn('login_browser', 'string', [
            'default' => null,
            'limit'   => 50,
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
        $table->addColumn('country_code', 'string', [
            'default' => null,
            'limit'   => 3,
            'null'    => false,
        ]);
        $table->addColumn('calling_code', 'string', [
            'default' => null,
            'limit'   => 5,
            'null'    => false,
        ]);
        $table->addColumn('api_key_plain', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false,
        ]);
        $table->addColumn('api_key', 'string', [
            'default' => null,
            'limit'   => 255,
            'null'    => false,
        ]);
        $table->addColumn('api_type', 'string', [
            'default' => null,
            'limit'   => 20,
            'null'    => false,
        ]);
        $table->create();
    }
}
