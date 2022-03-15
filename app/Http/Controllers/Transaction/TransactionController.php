<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,transactions')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();
        
        $transactions=Transactions::all();
        return $this->showAll($transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        return $this->showOne($transactions);
    }
}
