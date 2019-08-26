<?php
namespace Bridestiny\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class VendorSignInForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
            'email' => [
                'message' => 'Email is required',
            ]])
          ->notEmpty('email', 'Email is required')
          ->add('email', [
                'validFormat' => [
                    'rule'    => 'email',
                    'message' => 'Email must be in valid format',
                ]
            ])
          ->requirePresence('password')
          ->notEmpty('password', 'Please fill this field')
          ->add('password', [
                'size' => [
                    'rule'    => ['lengthBetween', 6, 20],
                    'message' => 'Password need to be at least 6 characters and maximum 20 characters'
                ]
            ]);

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}