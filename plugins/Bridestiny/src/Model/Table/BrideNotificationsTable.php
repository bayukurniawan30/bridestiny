<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideNotificationsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_notifications');
        $this->setPrimaryKey('id');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		if ($entity->isNew()) {
			$entity->created  = $date;
			$entity->is_read  = '0';
        }
	}
	public function checkRead($status)
	{
		$total = $this->find()->where(['is_read' => $status])->count();
		return $total;
	}
	public function findByRead(Query $query, array $options)
    {
        $read = $options['read'];
        return $query->where(['is_read' => $read])->order(['id' => 'DESC']);
    }
}