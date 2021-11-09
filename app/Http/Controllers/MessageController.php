<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
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
        if (\Request::ajax()) {

            $user = User::findOrFail($id);
            $message = $this->message_by_user_id($id);
            return response()->json([
                'message' => $message,
                'user' => $user,
            ]);
        }
        return abort(404);
    }

    public function send_message(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $message = Message::create([
            'message' => $request->message,
            'form' => auth()->user()->id,
            'to' => $request->user_id,
            'type' => 0
        ]);
        $message = Message::create([
            'message' => $request->message,
            'form' => auth()->user()->id,
            'to' => $request->user_id,
            'type' => 1
        ]);
        broadcast(new MessageSend($message));
        return response()->json($message, 201);
    }

    public function delete_single_message($id = null)
    {
        if (!\Request::ajax()) {
            abort(404);
        }
        Message::findOrFail($id)->delete();
        return response()->json('deleted', 200);
    }

    public function delete_all_message($id = null)
    {
        $messages =  $this->message_by_user_id($id);
        foreach ($messages as $message) {
            Message::findOrFail($message->id)->delete();
        }
        return response()->json('delete all message', 200);
    }

    public function message_by_user_id($id)
    {
        $message = Message::where(function ($q) use ($id) {
            $q->where('form', auth()->user()->id);
            $q->where('to', $id);
            $q->where('type', 0);
        })->orWhere(function ($q) use ($id) {
            $q->where('form', $id);
            $q->where('to', auth()->user()->id);
            $q->where('type', 1);
        })->with('user')->get();
        return $message;
    }
}
