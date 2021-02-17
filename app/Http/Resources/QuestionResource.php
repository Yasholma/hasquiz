<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quizId' => $this->quiz_id,
            'question' => $this->question,
            'answers' => AnswerResource::collection($this->answers),
            'time' => $this->time
        ];
    }
}
