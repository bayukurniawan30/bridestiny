<?php
namespace Bridestiny\Validator\Api;

use Cake\Validation\Validator;

class VendorSignInValidator
{
    public function validate()
    {
        $validator = new Validator();
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
}