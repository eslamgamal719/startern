<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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

                'name_ar'      => 'required|max:100|unique:offers,name_ar',
                'name_en'      => 'required|max:100|unique:offers,name_en',
                'price'        => 'required|numeric',
                'details_ar'   => 'required',
                'details_en'   => 'required',
                'photo'        => 'required|mimes:png,jpg,jpeg',
            ];
    }


    public function messages() {

        return [

                    'name_ar.required'       => __('messages.offer name required ar'),
                    'name_en.required'       => __('messages.offer name required en'),
                    'price.required'         => __('messages.price required'),
                    'details_ar.required'    => __('messages.details required ar'),
                    'details_en.required'    => __('messages.details required en'),
                    'name.max'               => __('messages.name max length'),
                    'price.numeric'          => __('messages.price numeric'),
                    'name_ar.unique'         => __('messages.name unique ar'),
                    'name_en.unique'         => __('messages.name unique en'),
                    'photo.required'         => __('messages.photo required'),  
                    'photo.mimes'            => __('messages.photo mimes'), 
                ];
    }



}
