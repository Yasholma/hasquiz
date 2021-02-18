<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'questionId' => $this->question_id,
            'answer' => $this->answer
        ];

        $role = Auth::user()->role;
        if ($role === 'Admin') {
            $response['correct'] = $this->correct ? true : false;
        }

        return $response;
    }
}
