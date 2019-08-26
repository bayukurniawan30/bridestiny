<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Cake\Auth\DefaultPasswordHasher;
use Bridestiny\Functions\GlobalFunctions;

class BrideCustomer extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
    ];
    protected function _setPassword($password)
   	{
       	return (new DefaultPasswordHasher())->hash($password);
	}
    protected function _getTextStatus()
    {
        if ($this->status == '0') {
            return 'Draft';
        }
        elseif ($this->status == '1') {
            return 'Publish';
        }
    }
    protected function _getFullName()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
    protected function _getBrideType()
    {
        return 'Couples';
    }
    protected function _getMobilePhone()
    {
        return '+' . $this->calling_code . $this->phone;
    }
    protected function _getCreated($created)
    {
        $serverRequest   = new ServerRequest();
        $session         = $serverRequest->getSession();
        $timezone        = $session->read('Purple.timezone');
        $settingTimezone = $session->read('Purple.settingTimezone');

        $date = new \DateTime($created, new \DateTimeZone($settingTimezone));
        $date->setTimezone(new \DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }
    protected function _getModified($modified)
    {
        if ($modified == NULL) {
            return $modified;
        }
        else {
            $serverRequest   = new ServerRequest();
            $session         = $serverRequest->getSession();
            $timezone        = $session->read('Purple.timezone');
            $settingTimezone = $session->read('Purple.settingTimezone');

            $date = new \DateTime($modified, new \DateTimeZone($settingTimezone));
            $date->setTimezone(new \DateTimeZone($timezone));
            return $date->format('Y-m-d H:i:s');
        }
    }
}