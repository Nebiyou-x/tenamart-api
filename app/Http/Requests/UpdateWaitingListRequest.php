<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWaitingListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    $id = $this->route('id'); // For unique email check

    return [
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:waiting_lists,email,' . $id,
        'signup_source' => 'sometimes|string|in:referral,organic,social media',
    ];
    }

}
