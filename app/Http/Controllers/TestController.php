<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Services\TestService;
use App\Traits\Telegram;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use Telegram;
    public $service;

    public function __construct()
    {
        $this->service = new TestService();
    }

    public function index()
    {
        $tests = Test::all();
        return view('tests.index', compact('tests'));
    }

    public function create()
    {
        return view('tests.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'answers' => 'required',
        ]);

        $this->service->store($data);
        return redirect()->route('tests.index');
    }

    public function check(Request $request)
    {
        $update = json_decode(file_get_contents('php://input'));

        if (isset($update->message)) {
            $message = $update->message;
            $message_id = $message->message_id;
            $chat = $message->chat;
            $chat_id = $chat->id;
            $chat_type = $chat->type;
            $from = $message->from;
            $user_id = $from->id;
            $first_name = $from->first_name;
            $last_name = $from->last_name ?? null;
            $username = $from->username ?? null;

            if (isset($message->text)) {
                $text = $message->text;

                if ($chat_type == 'private') {
                    if ($text == '/start') {
                        $text = 'Hello, ' . $first_name . ' ' . $last_name . '!';
                        $this->sendMessage('sendMessage', [
                            'chat_id' => $chat_id,
                            'text' => $text,
                        ]);
                    }
                }
            }
        }
    }
}