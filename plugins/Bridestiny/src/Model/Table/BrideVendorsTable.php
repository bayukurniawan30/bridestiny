<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideVendorsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_vendors');
        $this->setPrimaryKey('id');
        $this->hasMany('Bridestiny.BrideReviews')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideVendorPosts')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BridePortfolios')
             ->setForeignKey('vendor_id');
        $this->hasOne('Bridestiny.BrideAbout')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideFaqs')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideVendorServices')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideCalendars')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideProducts')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideReviews')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideVendorAds')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideOrders')
             ->setForeignKey('vendor_id');
        $this->hasMany('Bridestiny.BrideVendorMedias')
             ->setForeignKey('vendor_id');
        $this->belongsToMany('Bridestiny.BrideChatMessages', [
            'joinTable'        => 'bride_chatMessages',
            'foreignKey'       => 'vendor_id',
            'targetForeignKey' => 'customer_id'
        ]);
        
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		// Sanitize and capitalize name
		$entity->name = ucwords(trim($entity->name));

		if ($entity->isNew()) {
			$entity->created  = $date;
        }
		else {
			$entity->modified = $date;
		}
	}
}