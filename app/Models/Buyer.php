<?php

namespace App\Models;
use App\Scopes\BuyerScope;
use App\Models\Transactions;
use App\Transformers\BuyerTransformer;

class Buyer extends User
{

    public $transformer=BuyerTransformer::class;

    public static function booted()
    {
        parent::booted();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions(){
        return $this->hasMany(Transactions::class);
    }
}
