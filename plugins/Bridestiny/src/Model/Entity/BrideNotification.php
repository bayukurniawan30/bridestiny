<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Bridestiny\Functions\GlobalFunctions;

class BrideNotification extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
    protected function _getTextStatus()
    {
        if ($this->is_read == '0') {
            return 'Unread';
        }
        elseif ($this->is_read == '1') {
            return 'Read';
        }
    }
    protected function _getLinkFromType()
    {
        if ($this->type == 'Vendors.new') {
            return 'Vendor';
        }
        elseif ($this->type == 'Customers.new') {
            return 'Customer';
        }
    }
    protected function _getTitleFromType()
    {
        if ($this->type == 'Vendors.new') {
            return 'New Vendor';
        }
        elseif ($this->type == 'Customers.new') {
            return 'New Customer';
        }
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