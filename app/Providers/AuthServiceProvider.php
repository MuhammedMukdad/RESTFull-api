<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Transactions;
use App\Policies\UserPolicy;
use App\Policies\BuyerPolicy;
use App\Policies\SellerPolicy;
use Laravel\Passport\Passport;
use App\Policies\ProductPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Buyer::class=>BuyerPolicy::class,
        Seller::class=>SellerPolicy::class,
        User::class=>UserPolicy::class,
        Transactions::class=>TransactionPolicy::class,
        Product::class=>ProductPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action',function($user){
            return $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
