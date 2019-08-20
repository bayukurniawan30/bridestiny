<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideCategoriesTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_categories');
		$this->setPrimaryKey('id');
		$this->hasMany('Bridestiny.BrideProducts')
             ->setForeignKey('category_id');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		$sluggedTitle = Text::slug(strtolower($entity->name));
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 191);

		if ($entity->isNew()) {
			$entity->created  = $date;
		}
		else {
			$entity->modified = $date;
		}
	}
	public function countCategoryStatus($status)
	{
		$categories = $this->find()->where(['status' => $status]);
		$total      = $categories->count();
		return $total;
	}
	public function hasChild($id)
	{
		$categories = $this->find()->where(['parent' => $id]);
		$total      = $categories->count();
		if ($total > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}
	public function selectBoxParent()
	{
		$loadParent = $this->find('list')->select(['id','name'])->where(['parent is' => NULL])->order(['id' => 'ASC'])->toArray();
		return $loadParent;
	}
}