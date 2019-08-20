<?php
namespace Bridestiny\Form\Purple;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CurrencyEditForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
                    'code' => [
                        'message' => 'Currency code is required',
                    ]])
                  ->notEmpty('code', 'Currency code is required')
                  ->add('code', [
                        'minLength' => [
                            'rule'    => ['minLength', 3],
                            'message' => 'Currency code need to be at least 3 characters'
                        ],
                        'maxLength' => [
                            'rule'    => ['maxLength', 3],
                            'message' => 'Currency code is maximum 3 characters'
                        ]
                        
                    ])
                  ->requirePresence([
                    'status' => [
                        'message' => 'Please select status of the currency',
                    ]])
                  ->notEmpty('status', 'Please select status of the currency')
                  ->requirePresence([
                    'id' => [
                        'message' => 'Currency id is required',
                    ]])
                  ->notEmpty('id', 'Currency id is required')
                  ->add('id', [
                        'isInteger' => [
                            'rule'    => ['isInteger'],
                            'message' => 'Currency id must be an integer value'
                        ]
                    ]);

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}