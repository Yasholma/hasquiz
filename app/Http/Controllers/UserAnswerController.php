<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userAnswers.*.questionId' => 'required|numeric',
            'userAnswers.*.selectedAnswer' => 'required|numeric',
            'quizId' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        $quiz_id = $request->quizId;
        $userAnswers = $request->userAnswers;

        $total_questions = Quiz::find($quiz_id)->questions->count();
        $total_answered = count($userAnswers);

        $correct = 0;

        foreach ($userAnswers as $userAnswer) {
            $q_id = $userAnswer['questionId'];
            $selected_answer_id = $userAnswer['selectedAnswer'];

            $question = Question::find($q_id);
            $correct_answers = $question->answers->where('correct')->toArray();

            $correct_answer_id = collect($correct_answers)->mapWithKeys(function ($item) {
                return ['id' => $item['id']];
            })->toArray()['id'];

            if ($selected_answer_id === $correct_answer_id) {
                $correct += 1;
            }

            UserAnswer::create([
                'user_id' => $user->id,
                'question_id' => $q_id,
                'answer_id' => $selected_answer_id
            ]);
        }

        $meta = [
            'totalAnswered' => $total_answered,
            'correctCount' => $correct,
            'totalQuestions' => $total_questions,
            'user' => $user
        ];

        return response()->json(['message' => 'Test submitted successfully.', 'meta' => $meta], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(UserAnswer $userAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAnswer $userAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAnswer $userAnswer)
    {
        //
    }
}
