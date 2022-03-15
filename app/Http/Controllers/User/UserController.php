<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserMailChanged;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    public function __construct()
    {

        $this->middleware('client.credentials')->only(['store','resend']);
        $this->middleware('auth:api')->except(['stor','verifiy','update']);
        $this->middleware('transform.input:'.UserTransformer::class)->only(['stor','update']);

        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();

        $users=User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ];

       // $request->validate($rules);
      $this->validate($request,$rules);

        $data=$request->all();
        $data['password']=bcrypt($request->password);
        $data['verified']=User::UNVERIFIED_USER;
        $data['admin']=User::REGULAR_USER;
        $data['verification_token']=User::generateVerificationToken();

        $user=User::create($data);

        return $this->showOne($user,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $rules=[
            'email'=>'email|unique:users',
            'password'=>'min:6',
            'admin'=>'in'.User::REGULAR_USER.','.User::ADMIN_USER,
        ];

        $this->validate($request,$rules);

        if($request->has('name')){
            $user->name=$request->name;
        }

        if($request->has('email')&&$user->email!=$request->email){
            $user->verified=User::UNVERIFIED_USER;
            $user->verification_token=User::generateVerificationToken();
            $user->email=$request->email;

        }
        if($request->has('password')){
            $user->password=bcrypt($request->password);
        }
        if($request->has('admin')){
            $this->allowedAdminAction();
            
            if(!$user->isVerified()){
                return $this->errorResponse('Only verified users can modify the admin filed',409);
            }
            $user->admin=$request->admin;
        }
        if(!$user->isDirty()){
            return $this->errorResponse('you need to put deffirent value',422);
        }
        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    public function verifiy($token){
        $user=User::where('verification_token',$token)->firstOrFail();

        $user->verified=User::VERIFIED_USER;
        $user->verification_token=null;

        $user->save();

        return $this->showMessage('Your email verified successfuly');
    }

    public function resend(User $user){

        if($user->isVerifird()){
            return $this->errorResponse('this user is already verified ',409);
        }
        retry(5,function() use($user){
            Mail::to($user)->send(new UserMailChanged($user));
    },100);
        return $this->showMessage('the verification email has been resend');
    }
}
