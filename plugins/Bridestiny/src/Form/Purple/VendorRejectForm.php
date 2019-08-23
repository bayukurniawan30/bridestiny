<?php
namespace Bridestiny\Form\Purple;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class VendorRejectForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
                    'id' => [
                        'message' => 'Vendor id is required',
                    ]])
                  ->notEmpty('id', 'Vendor id is required')
                  ->add('id', [
                        'isInteger' => [
                            'rule'    => ['isInteger'],
                            'message' => 'Vendor id must be an integer value'
                        ]
                    ])
                  ->allowEmpty('decline_reason');

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}