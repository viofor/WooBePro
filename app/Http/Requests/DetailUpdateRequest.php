<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\detail;
use Illuminate\Support\Facades\Auth;

class DetailUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Auth::user()->id;
        $detail = detail::where('user_id', $id)->get();
        $usertype = $detail[0]->usertype;
        if ($usertype == '2') {              //if the user is a professional
            return [
                'country' => 'required|numeric|between:1,197',
                'state' => 'string',
                'city' => 'string',
                'resume' => 'required|string',
                'skill' => 'required|string',
                'schedule' => 'required|string',
            ];
        }else{
            return [
                'country' => 'required|numeric|between:1,197',
                'state' => 'string',
                'city' => 'string',
            ];
        }
    }
    public function messages()
    {
    return [
        'country.required' => 'Please choose a :attribute.',
        'country.numeric' => 'The :attribute must be withing the options.',
        'country.|between:1,197' => 'The :attribute must be withing the options.',
        'state.string' => ':attribute must be a valid name.',
        'city.string' => ':attribute must be a valid name.',
        'schedule.required' => 'State your :attribute of work',
        'schedule.string' => ':attribute must be alphanumeric value',
        'resume.required' => 'Add a :attribute to your profile',
        'resume.string' => ':attribute must be alphanumeric value',
        'skill.required' => 'Add your skills to your profile',
        'skill.string' => ':attribute must be alphanumeric value',
    ];
    }    
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
 
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}