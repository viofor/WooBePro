<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
        if ('usertype' == '2') {              //if the user is a professional
            return [
                'user_id' => 'required|numeric',
                'usertype' => 'required|numeric|between:1,2',
                'country' => 'required|numeric|between:1,197',
                'state' => 'alpha',
                'city' => 'alpha',
                'resume' => 'required|alpha_num',
                'skill' => 'required|alpha_num',
                'schedule' => 'required|alpha_num',
            ];
        }else{
            return [
                'user_id' => 'required|numeric',
                'usertype' => 'required|numeric|between:1,2',
                'country' => 'required|numeric|between:1,197',
                'state' => 'alpha',
                'city' => 'alpha',
            ];
        }
    }
    public function messages()
    {
    return [
        'user_id.required' => ':attribute is mandatory.',
        'user_id.numeric' => ':attribute must be a integer.',
        'usertype.required' => ':attribute is mandatory.',
        'usertype.numeric' => ':attribute must be withing the options.',
        'usertype.between:1,2' => ':attribute must be withing the options.',
        'country.required' => 'Please choose a :attribute.',
        'country.numeric' => 'The :attribute must be withing the options.',
        'country.|between:1,197' => 'The :attribute must be withing the options.',
        'state.alpha' => ':attribute must be a valid name.',
        'city.alpha' => ':attribute must be a valid name.',
        'schedule.required' => 'State your :attribute of work',
        'schedule.alpha_num' => ':attribute must be alphanumeric value',
        'resume.required' => 'Add a :attribute to your profile',
        'resume.alpha_num' => ':attribute must be alphanumeric value',
        'skill.required' => 'Add your skills to your profile',
        'skill.alpha_num' => ':attribute must be alphanumeric value',
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
