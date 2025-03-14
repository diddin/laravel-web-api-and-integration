<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if($method == 'PUT') {
            return [
                'title' => 'required|max:255', //'required|unique:posts|max:255'
                'content' => 'required',
            ];
        } else {
            return [
                'title' => 'sometimes|required|max:255',
                'content' => 'someimes|required',
            ];
        }
        
    }
}
