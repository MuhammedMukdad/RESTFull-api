<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Seller;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization,AdminActions;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can sale product.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function sale(User $user,User $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function editProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }
}
