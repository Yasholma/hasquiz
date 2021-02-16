<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuizResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuestionResource::collection(Question::all());
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
            'question' => 'required|string|min:3|max:250',
            'time' => 'required|numeric',
            'answers.*.answer' => 'required|string',
            'answers.*.correct' => 'required|boolean'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $quiz_id = 1;
        $question = new Question();

        DB::transaction(function () use ($request, $question, $quiz_id) {

            $question->quiz_id = $quiz_id;
            $question->question = $request->question;
            $question->time = $request->time;

            $question->save();

            foreach ($request->answers as $answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $answer['answer'],
                    'correct' => $answer['correct']
                ]);
            }

            // update total time for this quiz
            $quiz = Quiz::find($quiz_id);
            $questions = $quiz->questions()->get()->toArray();
            $quiz->total_time = $this->calculateTotalTime($questions);
            $quiz->save();
        });

        return response()->json([
            'message' => 'Question and answers created successfully',
            'question' => new QuestionResource($question)
        ], 201);
    }

    private function calculateTotalTime($questions): int
    {
        return collect(Arr::pluck($questions, 'time'))->sum();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(['message' => 'Question deleted.']);
    }
}
