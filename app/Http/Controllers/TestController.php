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
            $chat = $message->chat;
            $chat_id = $chat->id;
            $chat_type = $chat->type;
            $from = $message->from;
            $first_name = $from->first_name;
            $last_name = $from->last_name ?? null;

            if (isset($message->text)) {
                $text = $message->text;

                if ($chat_type == 'private') {
                    if ($text == '/start') {
                        $text = "Salom " . $first_name . " " . $last_name . "! \n\nTest javobini tekshirish quyidagicha amalga oshiriladi. \nTestKodi\\*1a2b3c4d...";
                        $this->sendMessage('sendMessage', [
                            'chat_id' => $chat_id,
                            'text' => $text,
                            'parse_mode' => 'markdown'
                        ]);
                    } else {
                        //get first 6 characters from text and get tests by test_code
                        $test_code = substr($text, 0, 6);
                        $test = Test::where('test_code', $test_code)->first();
                        if (!$test) {
                            $text = "Test topilmadi!";
                            $this->sendMessage('sendMessage', [
                                'chat_id' => $chat_id,
                                'text' => $text,
                                'parse_mode' => 'markdown'
                            ]);
                        } else {
                            $correctAnswers = json_decode($test->answers, true);

                            $userAnswersText = substr($text, 7); // remove the first 6 characters (the test code)
                            $userAnswersArray = str_split($userAnswersText); // split the remaining string into an array of characters

                            $userAnswers = [];
                            for ($i = 0; $i < count($userAnswersArray); $i += 2) {
                                $userAnswers[$userAnswersArray[$i]] = $userAnswersArray[$i + 1];
                            }

                            $correctCount = 0;
                            foreach ($correctAnswers as $question => $correctAnswer) {
                                if (isset($userAnswers[$question]) && $userAnswers[$question] == $correctAnswer) {
                                    $correctCount++;
                                }
                            }

                            $text = "Siz {$correctCount}ta savolga to'g'ri javob berdingiz.\n\n";

                            foreach ($correctAnswers as $question => $correctAnswer) {
                                $userAnswer = $userAnswers[$question] ?? 'No answer';
                                //if user answer is correct then add ✅ emoji else add ❌ emoji and also add the correct answer
                                $text .= "$question. $userAnswer " . ($userAnswer == $correctAnswer ? '✅' : '❌');
                                if ($userAnswer != $correctAnswer) {
                                    $text .= " To'g'ri javob: $correctAnswer";
                                }
                                $text .= "\n";
                            }

                            $this->sendMessage('sendMessage', [
                                'chat_id' => $chat_id,
                                'text' => $text,
                                'parse_mode' => 'markdown'
                            ]);
                        }
                    }
                }
            }
        }
    }
}