<?php
namespace Bridestiny\Form\Purple;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CurrencyAddForm extends Form
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
                        'message' => 'Currency status is required',
                    ]])
                  ->notEmpty('status', 'Please select status of the currency');

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}