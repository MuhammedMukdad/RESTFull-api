<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
    public function __construct()
    {

        $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $transactions=Transactions::findOrFail($id);

        $categories= $transactions->product->categories;

        return $this->showAll($categories);
    }
}
