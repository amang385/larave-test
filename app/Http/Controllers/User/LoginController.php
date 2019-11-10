<?php

namespace App\Http\Controllers\User;
use App\User;
use App\Facebook;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){

        
        return view('auth.login');
    }


   public function login(Request $request)
   {
       // แบบที่1
       $user=\App\User::where('email',$request->email)
       ->get()->first();

    //    if(Hash::check(
    //        $request->passwork, $user->password
           
        //    )){
            //    แบบที่1.1
            //   Auth::login($user);
            //   return redirect()->route('home');
            
              //    แบบที่1.2
            //   Auth::loginUsingId($user->id);
            //   return redirect()->route('home');

        //    }

           //แบบที่ 2

           $isAuth = Auth::attempt([
               'email'=> $request->email,
               'password'=>$request->password,
           ]);

           if(!$isAuth){
                return redirect()->back();
           }
        
           return redirect()->route('home');

    //    $user = \App\User::where([
    //        'email'=>$request->email,

    //    ])->get(['password','name']);
       

        // dd($user);
    //    dd($user->password);
    //    dd($request->all());
   }
   public function logout()
   {
       
       Auth::logout();
       return redirect()->route('book.index');
   }
   public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallBack()
    {
        $facebookUser = Socialite::driver('facebook')
            ->stateless()->user();
    //check uesr
    $userExist=User::where('email',$facebookUser->email)->get()->first();

    //ถ้าว่างให้เพิ่มข้อมูลลง DB
    if(empty($userExist)){
        $user = new User();

        $user->name=$facebookUser->name;
        $user->email=$facebookUser->email;

        $user->org_auth='facebook';
        $user->org_id=$facebookUser->id;
        $user->save();

        $facebook = new Facebook();
        $facebook->id=$facebookUser->id;
        $facebook->token=$facebookUser->token;
        $facebook->refresh_token=$facebookUser->refreshToken;
        $facebook->expires_in=$facebookUser->expiresIn;
        $facebook->avatar_original=$facebookUser->avatar_original;
        $facebook->created_by=$user->id;
        $facebook->save();

        Auth::login($user);
        

    }else{
        //ถ้ามีข้อมูล
        Auth::login($userExist);
    }
    return redirect()->route('home');



        // dd($facebookUser);
    }
}
