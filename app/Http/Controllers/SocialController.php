<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Social;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function login_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback_google()
    {
        $users = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateUser($users, 'google');
        if ($authUser) {
            $account_name = User::where('id', $authUser->user)->first();
            Auth::login($account_name);
            // session()->put('name', $account_name->name);
            // session()->put('email', $account_name->email);
            // session()->put('id', $account_name->id);
        }
        return redirect('/');
    }

    //-------------------FaceBook---------------------------

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $users = Socialite::driver('facebook')->stateless()->user();
        $authUser = $this->findOrCreateUser($users, 'fackebook');
        if ($authUser) {
            $account_name = User::where('id', $authUser->user)->first();
            Auth::login($account_name);
        }
        return redirect('/');
    }

    public function findOrCreateUser($users, $provider)
    {
        try {
            $authUser = Social::where('provider_user_id', $users->id)->first();
            if ($authUser) {
                return $authUser;
            } else {
                $customer_new = new Social([
                    'provider_user_id' => $users->id,
                    'provider' => strtoupper($provider)
                ]);

                $orang = User::where('email', $users->email)->first();

                if (!$orang) {
                    $orang = User::create([
                        'name' => $users->name,
                        'email' => $users->email,
                        'password' => '',
                        'phone' => '',
                    ]);
                }
                $customer_new->login()->associate($orang);
                $customer_new->save();
                return $customer_new;
            }
        } catch (\Throwable $e) {
            return redirect()->route('admin.auth.login')->with('error', $e->getMessage());
            // dd($e->getMessage());
        }
    }
}
