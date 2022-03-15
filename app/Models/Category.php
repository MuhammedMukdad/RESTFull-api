<?php

namespace App\Models;

use App\Models\Product;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $date=['deleted_at'];
    protected $fillable= [
        'name',
        'description'
    ];
    protected $hidden=[
        'pivot'
    ];

    public $transformer=CategoryTransformer::class;

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
