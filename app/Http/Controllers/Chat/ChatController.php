<?php

namespace App\Http\Controllers\Chat;

use App\Events\GreetingSent;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        /** @var \App\Models\User $user */
        $authUser = Auth::user();

        broadcast(new MessageSent($authUser, $request->message));

        return response()->json(['status' => 'Ok']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function greet(Request $request, User $user)
    {
        /** @var \App\Models\User $user */
        $authUser = Auth::user();

        broadcast(new GreetingSent($user, "{$authUser->name} has greeted you!"));
        broadcast(new GreetingSent($authUser, "You have greeted {$user->name}!"));

        return response()->json(['status' => "Greeting {$user->name} from {$authUser->name}"]);
    }
}
