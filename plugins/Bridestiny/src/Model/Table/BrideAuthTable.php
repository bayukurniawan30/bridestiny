<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Http\ServerRequest;
use Cake\Utility\Security;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideAuthTable extends Table
{
	public function initialize(array $config)
	{
        $this->setTable('bride_auth');
        $this->setPrimaryKey('id');
        $this->hasOne('Bridestiny.BrideVendor')
            ->setForeignKey('auth_id');
    }
    public function findAuth(\Cake\ORM\Query $query, array $options)
     {
          $query
               ->select(['id', 'email', 'password', 'user_type'])
               ->where(['BrideAuth.status' => 1]);

          return $query;
     }
}