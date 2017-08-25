<?php

namespace HoursLoad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLoadFormRequest extends FormRequest
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
        $rules =[];

       /* foreach($this->request->get('hours') as $key => $val)
        {
            $rules['hours.'.$key] = 'valsum:';
        }*/

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];
        foreach($this->request->get('hours') as $key => $val)
        {
            $messages['hours.'.$key.'.required'] = 'A field is required';
        }
        return $messages;

    }
}
