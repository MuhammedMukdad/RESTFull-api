<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifire'=>(int)$seller->id,
            'name'=>(string)$seller->name,
            'email'=>(string)$seller->email,
            'isVerified'=>(int)$seller->verified,
            'creationDate'=>(string)$seller->created_at,
            'lastChange'=>(string)$seller->updated_at,
            'deletedDate'=>isset($seller->deleted_at) ? (string)$seller->deleted_at :null,

            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('sellers.show',$seller->id),
                ],

                [
                    'rel'=>'seller.categories',
                    'href'=>route('sellers.categories.index',$seller->id),
                ],

                [
                    'rel'=>'seller.products',
                    'href'=>route('sellers.products.index',$seller->id),
                ],

                [
                    'rel'=>'seller.buyers',
                    'href'=>route('sellers.buyers.index',$seller->id),
                ],

                [
                    'rel'=>'seller.transactios',
                    'href'=>route('sellers.transactions.index',$seller->id),
                ],

                [
                    'rel'=>'user.profile',
                    'href'=>route('users.show',$seller->id),
                ],
            ]
        ];
    }

    public static function realAttr($index){

        $attr=[
            'identifire'=>'id',
            'name'=>'name',
            'email'=>'email',
            'isVerified'=>'verified',
            'creationDate'=>'created_at',
            'lastChange'=>'updated_at',
            'deletedDate'=>'deleted_at',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }

    public static function transformedAttr($index){

        $attr=[
            'id'=>'identifire',
            'name'=>'name',
            'email'=>'email',
            'verified'=>'isVerified',
            'created_at'=>'creationDate',
            'updated_at'=>'lastChange',
            'deleted_at'=>'deletedDate',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }
}
