<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,transactions')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $transaction=Transactions::findOrFail($id);
        $seller=$transaction->product->seller;

        return $this->showOne($seller);
    }
}
