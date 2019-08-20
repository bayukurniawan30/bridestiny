<?php

namespace Bridestiny\View\Cell;

use Cake\View\Cell;

class CategoriesCell extends Cell
{
    public function parentCategory($parent)
    {
    	$this->loadModel('Bridestiny.BrideCategories');
        $parentCategory = $this->BrideCategories->find()->where(['id' => $parent])->first();
        $this->set('parentName', $parentCategory->name);
    }
    public function totalPackagesInCategory($categoryId)
    {
        $this->loadModel('Bridestiny.BrideCategories');
        $this->loadModel('Bridestiny.BrideProducts');
        // Check for child category
        $children = $this->BrideCategories->find()->where(['parent' => $categoryId]);
        if ($children->count() > 0) {
            // If has child
            $totalProductsInChild = 0;
            foreach ($children as $child) {
                $products              = $this->BrideProducts->find()->where(['category_id' => $child->id]);
                $totalProductsInChild += $products->count();
            }

            $products = $this->BrideProducts->find()->where(['category_id' => $categoryId]);
            $total = $products->count() + $totalProductsInChild;
        }
        else {
            // Don't have child
            $products = $this->BrideProducts->find()->where(['category_id' => $categoryId]);
            $total    = $products->count();
        }

        $this->set('total', $total);
    }
}