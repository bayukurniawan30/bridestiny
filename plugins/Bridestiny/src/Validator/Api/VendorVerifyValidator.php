<?php
namespace Bridestiny\Validator\Api;

use Cake\Validation\Validator;

class VendorVerifyValidator
{
    public function validate()
    {
        $validator = new Validator();
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
}