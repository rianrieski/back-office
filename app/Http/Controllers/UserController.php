<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{

    public function __construct()
    {
        // $this->middleware('can:user list', ['only' => ['index', 'show']]);
        // $this->middleware('can:user create', ['only' => ['create', 'store']]);
        // $this->middleware('can:user edit', ['only' => ['edit', 'update']]);
        // $this->middleware('can:user delete', ['only' => ['destroy']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = (new User)->newQuery();
        $users->latest();
        $users = $users->paginate(100)->onEachSide(2)->appends(request()->query());
        return Inertia::render('User/Index', [
            'users' => $users,
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
