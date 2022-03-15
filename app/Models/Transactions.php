<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory,SoftDeletes;

    protected $date=['deleted_at'];
    protected $table='transactions';
    protected $fillable=[
        'quantitiy',
        'buyer_id',
        'product_id'
    ];

    public $transformer=TransactionTransformer::class;

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
