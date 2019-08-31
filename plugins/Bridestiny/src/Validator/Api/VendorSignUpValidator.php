<?php
namespace Bridestiny\Validator\Api;

use Cake\Validation\Validator;

class VendorSignUpValidator
{
    public function validate()
    {
        $validator = new Validator();
        $validator->requirePresence([
            'name' => [
                'message' => 'Name is required',
            ]])
          ->notEmpty('name', 'Name is required')
          ->add('name', [
                'minLength' => [
                    'rule'    => ['minLength', 2],
                    'message' => 'Name need to be at least 2 characters'
                ],
                'maxLength' => [
                    'rule'    => ['maxLength', 50],
                    'message' => 'Name is maximum 50 characters'
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
            'address' => [
                'message' => 'Address is required',
            ]])
          ->notEmpty('address', 'Address is required')
          ->add('address', [
                'minLength' => [
                    'rule'    => ['minLength', 5],
                    'message' => 'Address need to be at least 5 characters'
                ],
                'maxLength' => [
                    'rule'    => ['maxLength', 100],
                    'message' => 'Address is maximum 100 characters'
                ]
            ])
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
            'ktp_number' => [
                'message' => 'KTP number is required',
            ]])
          ->notEmpty('ktp_number', 'KTP number is required')
          ->requirePresence([
            'npwp' => [
                'message' => 'NPWP is required',
            ]])
          ->notEmpty('npwp', 'NPWP is required')
          ->requirePresence([
            'npwp_number' => [
                'message' => 'NPWP number is required',
            ]])
          ->notEmpty('npwp_number', 'NPWP number is required');

        return $validator;
    }
}