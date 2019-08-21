<?php
namespace Bridestiny\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class VendorCodeVerificationForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
                    'code' => [
                        'message' => 'Code is required',
                    ]])
                  ->notEmpty('code', 'Code is required')
                  ->add('code', [
                        'minLength' => [
                            'rule'    => ['minLength', 6],
                            'message' => 'Code need to be at least 6 characters'
                        ],
                        'maxLength' => [
                            'rule'    => ['maxLength', 6],
                            'message' => 'Code is maximum 6 characters'
                        ]
                    ]);

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}