<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'=>(int)$category->id,
            'title'=>(string)$category->name,
            'details'=>(string)$category->description,
            'creationDate'=>(string)$category->created_at,
            'lastChange'=>(string)$category->updated_at,
            'deleteDate'=>isset($category->deleted_at) ? (string)$category->deleted_at : null,

            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('categories.show',$category->id),
                ],

                [
                    'rel'=>'category.sellers',
                    'href'=>route('categories.sellers.index',$category->id),
                ],

                [
                    'rel'=>'category.buyers',
                    'href'=>route('categories.buyers.index',$category->id),
                ],

                [
                    'rel'=>'category.products',
                    'href'=>route('categories.products.index',$category->id),
                ],

                [
                    'rel'=>'category.transactions',
                    'href'=>route('categories.transactions.index',$category->id),
                ],
            ]
        ];
    }

    public static function realAttr($index){

        $attr=[
            'identifire'=>'id',
            'title'=>'name',
            'details'=>'description',
            'creationDate'=>'created_at',
            'lastChange'=>'updated_at',
            'deletedDate'=>'deleted_at',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }

    public static function transformedAttr($index){

        $attr=[
            'id'=>'identifire',
            'name'=>'title',
            'description'=>'details',
            'created_at'=>'creationDate',
            'updated_at'=>'lastChange',
            'deleted_at'=>'deletedDate',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }
}
