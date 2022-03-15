<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model=\App\Models\User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $password;
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' =>$password ?:$password =bcrypt('secret'),
            'remember_token' => Str::random(10),
            'verified'=>$verified=$this->faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
            'verification_token'=>$verified==User::VERIFIED_USER ? null :User::generateVerificationToken(),
            'admin'=>$this->faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}