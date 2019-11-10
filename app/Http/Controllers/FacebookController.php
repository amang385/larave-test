<?php


namespace App\Http\Controllers;
use App\Facebook;
use Illuminate\Support\Facades\Auth;

use App\FacebookConnection\FacebookSDK;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function info()
    {//USerคนไหนlogin web เราอยู่
       
        // $user = Auth::user();
        // $assertToken=Facebook::where('id',$user->org_id)
        // ->get(['token'])
        // ->first();
        // dd($assertToken->token);

        //dd(Auth::user()->with('facebook')->get());

        //แบบที่1
        


        $accessToken = Auth::user()->facebook->token;
        $res = FacebookSDK::sdkConnect(
            $accessToken,
            // 'me/posts?fields=full_picture,message,shares',
            // 'me/posts'

            'me/posts?fields=full_picture,message,shares'
            
            );
        return response()->json(json_decode($res->getBody()));


    }
  
}
