<?php

namespace Bridestiny\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use App\Purple\PurpleProjectSettings;
use Carbon\Carbon;

class BrideSettingsTable extends Table
{
	public function initialize(array $config)
	{
		$this->setTable('bride_settings');
        $this->setPrimaryKey('id');
    }
}