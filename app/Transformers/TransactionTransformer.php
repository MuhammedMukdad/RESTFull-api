<?php

namespace App\Transformers;

use App\Models\Transactions;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transactions $transactions )
    {
        return [
            'identifire'=>(int)$transactions->id,
            'quantity'=>(int)$transactions->quantitiy,
            'buyer'=>(int)$transactions->buyer_id,
            'product'=>(int)$transactions->product_id,
            'creationDate'=>(string)$transactions->created_at,
            'lastChange'=>(string)$transactions->updated_at,
            'deletedDate'=>isset($transactions->deleted_at) ? (string)$transactions->deleted_at :null,

            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('transactions.show',$transactions->id),
                ],

                [
                    'rel'=>'transactions.categories',
                    'href'=>route('transactions.categories.index',$transactions->id),
                ],

                [
                    'rel'=>'transactions.seller',
                    'href'=>route('transactions.sellers.index',$transactions->id),
                ],

                [
                    'rel'=>'buyer',
                    'href'=>route('buyers.show',$transactions->buyer_id),
                ],

                [
                    'rel'=>'product',
                    'href'=>route('products.show',$transactions->product_id),
                ],
            ]
        ];
    }
    public static function realAttr($index){

        $attr=[
            'identifire'=>'id',
            'quantity'=>'quantitiy',
            'buyer'=>'buyer_id',
            'product'=>'product_id',
            'creationDate'=>'created_at',
            'lastChange'=>'updated_at',
            'deletedDate'=>'deleted_at',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }

    public static function transformedAttr($index){

        $attr=[
            'id'=>'identifire',
            'quantitiy'=>'quantity',
            'buyer_id'=>'buyer',
            'product_id'=>'product',
            'created_at'=>'creationDate',
            'updated_at'=>'lastChange',
            'deleted_at'=>'deletedDate',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }
}
