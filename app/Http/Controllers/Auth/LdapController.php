<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LdapController extends Controller
{

    public function showLoginForm(){
        $logo = asset('assets/logo.png');
        return Inertia::render('Auth/Ldap',[
            'logo'=>$logo
        ]);

    }
    public function login(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $uid 			= trim($request->username);
        $ldapserver 	= '10.1.1.2';
        $ldapuser 		= "bsn.local\\" . $uid;
        $ldappass     	= $request->password;
        $ldaptree    	= "DC=BSN,DC=local";
        try {
            $ldapconn = ldap_connect($ldapserver);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            try {
                ldap_bind($ldapconn, $ldapuser, $ldappass);
                $filter = "(sAMAccountName=$uid)";
                $attr = array("cn", "mail", "l", "userPrincipalName");
                $result = ldap_search($ldapconn, $ldaptree, $filter, $attr) or die("Error in search query: " . ldap_error($ldapconn));
                $data = ldap_get_entries($ldapconn, $result);
                ldap_close($ldapconn);
                if ($data['count'] > 0) {
                    // cek username di sparta
                    $user = User::where('username', $uid)->first();
                    if ($user != NULL) {
                        Auth::login($user);
                        $request->session()->regenerate();
                        return Inertia::render('Dashboard');
                    } else {
                        return redirect()
                            ->back()
                            ->withInput($request->only('username', 'remember'))
                            ->with('error', trans('auth.ldap_no_account'));
                    }
                } else {
                    return redirect()
                        ->back()
                        ->withInput($request->only('username', 'remember'))
                        ->with('error', trans('auth.failed'));
                }
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput($request->only('username', 'remember'))
                    ->with('error', trans('auth.failed'));
            }
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->only('username', 'remember'))
                ->with('error', trans('auth.ldap_server_fail'));
        }
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login/ldap');
    }
}
