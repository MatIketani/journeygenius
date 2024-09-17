<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TravelPlanValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * This method runs before the validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $accommodation = $this->input('accommodation', '{}');

        $this->merge([
            'accommodation' => json_decode($accommodation, true),
            'max_distance' => intval($this->input('max_distance', 1)),
            'spending' => intval($this->input('spending', 1))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'accommodation' => ['required', 'array'],
            'max_distance' => ['required', 'integer', 'min:1', 'max:50'],
            'interests' => ['required', 'array'],
            'interests.*' => ['required', 'string'],
            'spending' => ['required', 'numeric', 'min:1', 'max:5'],
        ];
    }
}
