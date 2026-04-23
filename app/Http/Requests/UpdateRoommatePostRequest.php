<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoommatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is($this->route('roommatePost')?->user) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:140'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'post_type' => ['required', Rule::in(['looking_for_place', 'looking_for_roommates', 'forming_group'])],
            'budget_min' => ['nullable', 'integer', 'min:0'],
            'budget_max' => ['nullable', 'integer', 'min:0', 'gte:budget_min'],
            'move_in_date' => ['nullable', 'date'],
            'preferred_property_type' => ['nullable', Rule::in(['apartment', 'condo', 'house', 'bedspace'])],
            'region' => ['required', 'string', 'max:120'],
            'province' => ['required', 'string', 'max:120'],
            'city_municipality' => ['required', 'string', 'max:120'],
            'district_or_barangay' => ['nullable', 'string', 'max:120'],
            'roommate_intent' => ['required', Rule::in(['looking_for_room', 'looking_for_roommates', 'either'])],
        ];
    }
}
