<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        return [
            'name' => 'required|alpha|max:255',
            'lastname' => 'required|alpha|max:255',
            'phone' => 'required|numeric',
        ];
    }

    public function messages()
    {
    return [
        'name.required' => 'Please enter your name',
        'name.alpha' => 'Please enter a valid value for your name',
        'lastname.required' => 'Please enter your lastname',
        'lastname.alpha' => 'Please enter a valid value for your lastname',
        'phone.required' => 'Please enter your cellphone',
        'phone.numeric' => 'Only numeric characters are acepted on phone field',
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
