<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Cake\Auth\DefaultPasswordHasher;
use Bridestiny\Functions\GlobalFunctions;

class BrideVendor extends Entity
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
            return 'Unverified';
        }
        elseif ($this->status == '1') {
            return 'Verified';
        }
        elseif ($this->status == '2') {
            return 'Banned';
        }
        elseif ($this->status == '3') {
            return 'Active';
        }
        elseif ($this->status == '4') {
            return 'Declined';
        }
    }
    protected function _getFullName()
    {
        return ucwords($this->name);
    }
    protected function _getBrideType()
    {
        return 'Vendor';
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