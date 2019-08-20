<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
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

		if ($entity->isNew()) {
			$entity->created  = $date;
			$entity->status   = '0';
        }
		else {
			$entity->modified = $date;
		}
	}
}