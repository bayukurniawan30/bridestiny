<?php

namespace EngageTheme\Functions;

use Cake\ORM\TableRegistry;
use Bridestiny\Functions\GlobalFunctions;

class ThemeFunction
{
    private $themeSlug = 'engage_theme';

    public function __construct($webroot) 
    {
        $this->webroot = $webroot;
    }
    public function example()
    {
      	return "This is example of theme function.";
	}
	public function routePrefix()
	{
		// Plugin Function
		$globalFunction = new GlobalFunctions();
		$routePrefix    = $globalFunction->routePrefix();
		return $routePrefix;
	}
	public function purpleSetting($name)
	{
		$settingTable = TableRegistry::get('Settings');
		$setting      = $settingTable->find()->where(['name' => $name])->limit(1);
		if ($setting->count() > 0) {
			return $setting->first();
		}

		return false;
	}
}