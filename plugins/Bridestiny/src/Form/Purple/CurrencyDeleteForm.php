<?php
namespace Bridestiny\Form\Purple;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CurrencyDeleteForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
                    'id' => [
                        'message' => 'Currency id is required',
                    ]])
                  ->notEmpty('id', 'Please fill this field')
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