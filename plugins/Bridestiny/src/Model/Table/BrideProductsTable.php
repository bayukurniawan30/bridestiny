<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideProductsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_products');
        $this->setPrimaryKey('id');
        $this->belongsTo('Bridestiny.BrideCategories')
		     ->setForeignKey('category_id')
             ->setJoinType('INNER');
        $this->hasMany('Bridestiny.BrideOrders')
             ->setForeignKey('product_id');
        $this->belongsToMany('Bridestiny.BrideCustomers', [
			'joinTable'        => 'bride_wishlists',
			'foreignKey'       => 'product_id',
			'targetForeignKey' => 'customer_id'
        ]);
        $this->hasOne('Bridestiny.BrideProductDiscounts')
			 ->setForeignKey('product_id');
    }
    public function beforeSave($event, $entity, $options)
    {
    	$purpleSettings = new PurpleProjectSettings();
		$timezone       = $purpleSettings->timezone();
		$date           = Carbon::now($timezone);

		if ($entity->isNew()) {
			$entity->created  = $date;
        }
		else {
			$entity->modified = $date;
		}
	}
}