<?php

namespace App\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return $this->isMethod('PUT') ? $this->onUpdate() : $this->onCreate();
    }

    public function onCreate(){
        return [
            'name' => 'required|string|max:255',
            'track_id' => 'required|integer|exists:tracks,id',
            'session_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
            'location' => 'required|in:online,offline',
        ];

    }

    public function onUpdate(){
        return [
            'name' => 'required|string|max:255',
            'track_id' => 'required|integer|exists:tracks,id',
            'session_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
            'location' => 'required|in:online,offline',
        ];
    }
}
