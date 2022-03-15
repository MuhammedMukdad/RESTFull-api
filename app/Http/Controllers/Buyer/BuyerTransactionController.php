<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
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
        $transaction= $buyer->transactions;

        return $this->showAll($transaction);
    }
}
