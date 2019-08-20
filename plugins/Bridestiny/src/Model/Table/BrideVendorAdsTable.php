<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideVendorAdsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_vendor_ads');
        $this->setPrimaryKey('id');
        $this->belongsTo('Bridestiny.BrideVendors')
		     ->setForeignKey('vendor_id')
             ->setJoinType('INNER');
        $this->hasMany('Bridestiny.BrideAdsPayments')
             ->setForeignKey('vendor_ads_id');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		if ($entity->isNew()) {
			$entity->created  = $date;
			$entity->status   = '3';
        }
		else {
			$entity->modified = $date;
		}
	}
}