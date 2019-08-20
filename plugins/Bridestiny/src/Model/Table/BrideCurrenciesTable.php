<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideCurrenciesTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_currencies');
        $this->setPrimaryKey('id');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		// Sanitize and capitalize name
		$entity->code = strtoupper(str_replace(' ', '', trim($entity->code)));

		if ($entity->isNew()) {
			$entity->created  = $date;
            $entity->ordering = '1';
		}
		else {
			$entity->modified = $date;
		}
	}
	public function countCurrenciesStatus($status)
	{
		$currencies = $this->find()->where(['status' => $status]);
		$total      = $currencies->count();
		return $total;
	}
	public function availableCurrenciesInStore()
	{
		$currencies = $this->find()->where(['status' => '1']);
		return $currencies;
	}
}