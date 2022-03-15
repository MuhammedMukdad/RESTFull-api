<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,buyer')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();
        $buyers=Buyer::has('transactions')->get();

        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
       // $buyer=Buyer::has('transactions')->findOrFail($id);

        return $this->showOne($buyer);
    }
}
