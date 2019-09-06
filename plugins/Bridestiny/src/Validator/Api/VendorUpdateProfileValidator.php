<?php
namespace Bridestiny\Validator\Api;

use Cake\Validation\Validator;

class VendorUpdateProfileValidator
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
            'user_id' => [
                'message' => 'Vendor ID is required',
            ]])
          ->notEmpty('user_id', 'Vendor ID is required')
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
          ->notEmpty('province', 'Province is required')
          ->requirePresence([
            'city' => [
                'message' => 'City is required',
            ]])
          ->notEmpty('city', 'City is required')
          ->requirePresence([
            'about' => [
                'message' => 'About is required',
            ]])
          ->notEmpty('about', 'About is required');

        return $validator;
    }
}