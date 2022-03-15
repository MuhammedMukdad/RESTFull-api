<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifire'=>(int)$user->id,
            'name'=>(string)$user->name,
            'email'=>(string)$user->email,
            'isVerified'=>(int)$user->verified,
            'creationDate'=>(string)$user->created_at,
            'isAdmin'=>($user->admin==='true'),
            'lastChange'=>(string)$user->updated_at,
            'deletedDate'=>isset($user->deleted_at) ? (string)$user->deleted_at :null,

            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('users.show',$user->id),
                ],
            ]
        ];
    }

    public static function realAttr($index){

        $attr=[
            'identifire'=>'id',
            'name'=>'name',
            'email'=>'email',
            'isVerified'=>'verified',
            'creationDate'=>'created_at',
            'isAdmin'=>'admin',
            'lastChange'=>'updated_at',
            'deletedDate'=>'deleted_at',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }

    public static function transformedAttr($index){

        $attr=[
            'id'=>'identifire',
            'name'=>'name',
            'email'=>'email',
            'verified'=>'isVerified',
            'admin'=>'isAdmin',
            'created_at'=>'creationDate',
            'updated_at'=>'lastChange',
            'deleted_at'=>'deletedDate',
        ];
        return isset($attr[$index]) ? $attr[$index] : null ;
    }
}
