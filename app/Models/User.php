<?php

namespace App\Models;

use App\Transformers\UserTransformer;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasFactory,SoftDeletes,HasApiTokens;
    protected $date=['deleted_at'];

    protected $table='users';

    const VERIFIED_USER='1';
    const UNVERIFIED_USER='0';

    const ADMIN_USER='true';
    const REGULAR_USER='false';

    public $transformer=UserTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function setNameAttribute($name){
        $this->attributes['name']=strtolower($name);
    }

    public function getNameAttribute($name){
        return ucwords($name);
    }

    public function setEmailAttribute($email){
        $this->attributes['email']=strtolower($email);
    }

    public function getEmailAttribute($email){
        return ucwords($email);
    }

    public function isVerifird(){
        return $this->verified==User::VERIFIED_USER;
    }
    public function isAdmin(){
        return $this->verified==User::ADMIN_USER;
    }

    public static function generateVerificationToken(){
        return Str::random(40);
    }

}
