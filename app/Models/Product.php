<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Transactions;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $date=['deleted_at'];
    protected $table='products';

    const AVAILABLE_PRODUVT ='available';
    const UNAVAILABLE_PRODUVT ='unavailable';

    public $transformer=ProductTransformer::class;

    protected $fillable= [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden=[
        'pivot'
    ];

    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE_PRODUVT;
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
