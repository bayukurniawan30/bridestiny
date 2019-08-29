<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Cake\Auth\DefaultPasswordHasher;
use Bridestiny\Functions\GlobalFunctions;

class BrideAuth extends Entity
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
        if ($this->user_type == 'customer') {
            if ($this->status == '0') {
                return 'Unverified';
            }
            elseif ($this->status == '1') {
                return 'Active';
            }
            elseif ($this->status == '2') {
                return 'Banned';
            }
            elseif ($this->status == '3') {
                return 'Verified';
            }
        }
        elseif ($this->user_type == 'vendor') {
            if ($this->status == '0') {
                return 'Unverified';
            }
            elseif ($this->status == '1') {
                return 'Active';
            }
            elseif ($this->status == '2') {
                return 'Banned';
            }
            elseif ($this->status == '3') {
                return 'Verified';
            }
            elseif ($this->status == '4') {
                return 'Declined';
            }
        }
        
    }
}