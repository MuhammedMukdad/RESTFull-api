<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transactions;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization,AdminActions;



    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Transactions $transactions)
    {
        return $user->id === $transactions->buyer->id || $user->id === $transactions->product->seller->id;
    }

}
