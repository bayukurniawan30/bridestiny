<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideCouponsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_coupons');
        $this->setPrimaryKey('id');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		// Sanitize and capitalize name
		$entity->name = trim($entity->name);
		$entity->code = strtoupper(str_replace(' ', '', trim($entity->code)));
		$entity->description = trim($entity->description);
		$entity->term_and_condition = trim(htmlentities(nl2br($entity->term_and_condition)));

		if ($entity->isNew()) {
			$entity->created  = $date;
		}
		else {
			$entity->modified = $date;
		}
    }
}