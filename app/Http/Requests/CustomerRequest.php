<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required','email', $this->unique('email')],
        ];
    }

    /**
     * retorna a regra de validação unique
     *
     * @param string $column
     * @return Unique
     */
    private function unique(string $column): Unique
    {
        return Rule::unique(Customer::class, $column)->ignore(optional($this)->id);
    }


}
