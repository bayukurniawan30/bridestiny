<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideProductDiscountsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_product_discounts');
        $this->setPrimaryKey('id');
        $this->belongsTo('Bridestiny.BrideProducts')
		     ->setForeignKey('product_id')
             ->setJoinType('LEFT');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		if ($entity->isNew()) {
			$entity->created  = $date;
			$entity->status   = '0';
        }
		else {
			$entity->modified = $date;
		}
	}
}