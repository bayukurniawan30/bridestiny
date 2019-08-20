<?php
namespace Bridestiny\Form\Purple;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CustomerSignUpForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
            'first_name' => [
                'message' => 'First name is required',
            ]])
          ->notEmpty('first_name', 'First name is required')
          ->add('first_name', [
                'minLength' => [
                    'rule'    => ['minLength', 2],
                    'message' => 'First name need to be at least 2 characters'
                ],
                'maxLength' => [
                    'rule'    => ['maxLength', 50],
                    'message' => 'First name is maximum 50 characters'
                ]
            ])
          ->requirePresence([
            'last_name' => [
                'message' => 'Last name is required',
            ]])
          ->notEmpty('last_name', 'Last name is required')
          ->add('last_name', [
                'minLength' => [
                    'rule'    => ['minLength', 2],
                    'message' => 'Last name need to be at least 2 characters'
                ],
                'maxLength' => [
                    'rule'    => ['maxLength', 50],
                    'message' => 'Last name is maximum 50 characters'
                ]
            ])
          ->requirePresence([
            'password' => [
                'message' => 'Password is required',
            ]])
          ->notEmpty('password', 'Password is required')
          ->add('password', [
                'size' => [
                    'rule'    => ['lengthBetween', 6, 20],
                    'message' => 'Password need to be at least 6 characters and maximum 20 characters'
                ]
            ])
          ->requirePresence([
            'repeatpassword' => [
                'message' => 'Repeat Password is required',
            ]])
          ->notEmpty('repeatpassword', 'Repeat Password')
          ->add('repeatpassword', [
                'size'    => [
                    'rule'    => ['lengthBetween', 6, 20],
                    'message' => 'Password need to be at least 6 characters and maximum 20 characters'
                ]
            ])
          ->requirePresence([
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
          ->requirePresence([
            'address' => [
                'message' => 'Address is required',
            ]])
          ->notEmpty('address', 'Address is required')
          ->add('address', [
                'minLength' => [
                    'rule'    => ['minLength', 10],
                    'message' => 'Address need to be at least 10 characters'
                ],
                'maxLength' => [
                    'rule'    => ['maxLength', 100],
                    'message' => 'Address is maximum 100 characters'
                ]
                
            ])
          ->requirePresence([
            'phone' => [
                'message' => 'Phone is required',
            ]])
          ->notEmpty('phone', 'Phone is required')
          ->requirePresence([
            'province' => [
                'message' => 'Province is required',
            ]])
          ->notEmpty('province', 'Province is required')
          ->requirePresence([
            'city' => [
                'message' => 'City is required',
            ]])
          ->notEmpty('city', 'City is required')
          ->requirePresence([
            'ktp' => [
                'message' => 'KTP is required',
            ]])
          ->notEmpty('ktp', 'KTP is required')
          ->requirePresence([
            'NPWP' => [
                'message' => 'NPWP is required',
            ]])
          ->notEmpty('ktp', 'NPWP is required')
          ->allowEmpty('photo');

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}