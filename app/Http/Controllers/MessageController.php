<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function user_list()
    {
        if (\Request::ajax()) {
            $userlist = User::latest()->paginate(9);
            return response()->json($userlist, 200);
        }
        return abort(404);
    }
}
