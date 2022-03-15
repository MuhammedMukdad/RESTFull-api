<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization,AdminActions;


    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addCategory(User $user, Product $product)
    {
        return $user->id===$product->seller->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteCategory(User $user, Product $product)
    {
        return $user->id===$product->seller->id;
    }

}
