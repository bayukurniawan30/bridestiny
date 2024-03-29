<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideCheckListsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_check_lists');
        $this->setPrimaryKey('id');
        $this->belongsTo('Bridestiny.BrideCustomers')
		     ->setForeignKey('customer_id')
             ->setJoinType('INNER');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		if ($entity->isNew()) {
			$entity->created  = $date;
			$entity->status   = '1';
        }
		else {
			$entity->modified = $date;
		}
	}
}