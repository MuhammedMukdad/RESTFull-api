<?php

namespace App\Http\Controllers\Product;

use App\Models\User;
use App\Models\Product;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Transformers\TransactionTransformer;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'.TransactionTransformer::class)->only(['store']);
        $this->middleware('can:purchase,buyer')->only('store');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product, User $buyer)
    {

        $rules=[
            'quantity'=>'required|integer|min:1'
        ];

        $this->validate($request,$rules);

        if($buyer->id==$product->seller_id){
            return $this->errorResponse('the seller must be different from buyer',409);
        }

        if(!$buyer->isVerifird()){
            return $this->errorResponse('the buyer must be vreified',409);
        }

        if(!$product->seller->isVerifird()){
            return $this->errorResponse('the seller must be vreified',409);
        }

        if(!$product->isAvailable()){
            return $this->errorResponse('the product is not available',409);
        }

        if($product->quantity < $request->quantity){
            return $this->errorResponse('the product is not have enough units for this transaction',409);
        }

        return DB::transaction(function () use ($request,$product,$buyer){
            $product->quantity-=$request->quantity;
            $product->save();

            $transaction=Transactions::create([
                'quantitiy'=>$request->quantity,
                'buyer_id'=>$buyer->id,
                'product_id'=>$product->id
            ]);

            return $this->showOne($transaction);
        });

    }
}
