<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $userlist = User::latest()
                ->paginate(9);
            return response()->json($userlist, 200);
        }
        return abort(404);
    }


    public function user_message($id = null)
    {
        // return $user = Message::where('form', auth()->user()->id)->get();
        // if (\Request::ajax()) {
        $message = Message::where(function ($q) use ($id) {
            $q->where('form', auth()->user()->id);
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('form', $id);
            $q->where('to', auth()->user()->id);
        })->with('user')->get();
        return response()->json($message, 200);
        // }
        // return abort(404);
    }
}
