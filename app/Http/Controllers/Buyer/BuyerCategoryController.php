<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\APiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends APiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,buyer')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $categories=$buyer->transactions()->with('product.categories')
        ->get()
        ->pluck('product.categories')
        ->collapse()
        ->unique('id')
        ->values()
        ;
    return $this->showAll($categories);
    }
}
