<?php
namespace Bridestiny\Form\Purple;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CategoryEditForm extends Form
{
    protected function _buildValidator(Validator $validator)
    {
        $validator->requirePresence([
                    'name' => [
                        'message' => 'Category name is required',
                    ]])
                  ->notEmpty('code', 'Category name is required')
                  ->add('name', [
                        'minLength' => [
                            'rule'    => ['minLength', 3],
                            'message' => 'Category name need to be at least 3 characters'
                        ],
                        'maxLength' => [
                            'rule'    => ['maxLength', 100],
                            'message' => 'Category name is maximum 100 characters'
                        ]
                        
                    ])
                  ->requirePresence([
                    'description' => [
                        'message' => 'Description is required',
                    ]])
                  ->notEmpty('content', 'Description is required')
                  ->allowEmpty('image')
                  ->allowEmpty('icon')
                  ->allowEmpty('parent')
                  ->requirePresence([
                    'status' => [
                        'message' => 'Category status is required',
                    ]])
                  ->notEmpty('status', 'Please select status of the category')
                  ->requirePresence([
                    'id' => [
                        'message' => 'Category id is required',
                    ]])
                  ->notEmpty('id', 'Category id is required')
                  ->add('id', [
                        'isInteger' => [
                            'rule'    => ['isInteger'],
                            'message' => 'Category id must be an integer value'
                        ]
                    ]);

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }
}