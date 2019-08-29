<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\ServerRequest;
use Cake\Utility\Security;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideCustomersTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_customers');
        $this->setPrimaryKey('id');
        $this->hasMany('Bridestiny.BrideCheckLists')
             ->setForeignKey('customer_id');
        $this->hasMany('Bridestiny.BrideInspirations')
             ->setForeignKey('customer_id');
        $this->hasMany('Bridestiny.BrideReviews')
             ->setForeignKey('customer_id');
        $this->hasMany('Bridestiny.BrideWeddingDatas')
             ->setForeignKey('customer_id');
        $this->hasMany('Bridestiny.BrideOrders')
             ->setForeignKey('customer_id');
        $this->hasMany('Bridestiny.BrideCustomerMedias')
             ->setForeignKey('customer_id');
        $this->belongsToMany('Bridestiny.BrideWishlists', [
            'joinTable'        => 'bride_wishlists',
            'foreignKey'       => 'customer_id',
            'targetForeignKey' => 'product_id'
        ]);
        $this->belongsToMany('Bridestiny.BrideChatMessages', [
            'joinTable'        => 'bride_chatMessages',
            'foreignKey'       => 'customer_id',
            'targetForeignKey' => 'vendor_id'
        ]);
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		// Sanitize and capitalize name
		$entity->first_name = ucwords(trim($entity->first_name));
		$entity->last_name  = ucwords(trim($entity->last_name));
		$entity->phone      = str_replace('_', '', trim($entity->phone));

		if ($entity->isNew()) {
			$entity->created   = $date;
               $entity->status    = '0';
               $entity->user_type = 'customer';

               
               $hasher = new DefaultPasswordHasher();

               // Generate an API 'token'
               $entity->api_key_plain = Security::hash(Security::randomBytes(32), 'sha256', false);

               // Bcrypt the token so BasicAuthenticate can check
               // it during login.
               $entity->api_key = $hasher->hash($entity->api_key_plain);
        }
		else {
			$entity->modified = $date;
		}
     }
     public function countCustomerStatus($status)
	{
		$vendors = $this->find('all')->contain('BrideAuth')->where(['BrideAuth.status' => $status, 'BrideAuth.user_type' => 'customer']);
		$total   = $vendors->count();
		return $total;
     }
}