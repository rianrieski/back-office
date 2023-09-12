<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $userPermission = [];

        if ($request->user()){

            $user = User::find($request->user()->id);
            if (!$user) {
            } else {
                //Get Role Pada User yang Login
                $roles = $user->roles;

                foreach ($roles as $role) {
                    //Get Permission berdasarkan Role
                    $permissions = $role->permissions;
                    // Loop permission pada role
                    foreach ($permissions as $permission) {
                        $name = $permission->name;
                        $userPermission[Str::replace(' ', '_', $name)]= Auth::user()->can($name);
                    }
                }
            }
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'akses' => $userPermission ,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
