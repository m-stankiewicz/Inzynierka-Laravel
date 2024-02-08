<?php

namespace App\Http\Requests\Admin\VatRate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreVatRate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.vat-rate.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'rate' => ['required', 'numeric', 'between:0,100'], // stawka VAT jako wartość numeryczna, od 0 do 100
            'description' => ['nullable', 'string', 'max:255'], // opis jest opcjonalny, musi być stringiem o maksymalnej długości 255 znaków
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
