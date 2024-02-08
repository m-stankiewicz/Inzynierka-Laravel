<?php

namespace App\Http\Requests\Admin\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StoreCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.customer.create');
    }

    protected function prepareForValidation()
    {
        if ($this->has('is_company')) {
            $this->merge([
                'is_company' => $this->is_company === '1', // Konwersja na boolean
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'vat_id' => ['nullable', 'string', 'max:20', 'unique:customers,vat_id'], // Może być puste, ale jeśli jest podane, to jako string
            'email' => ['nullable', 'email', 'max:255'], // Może być puste, ale jeśli jest podane, to jako poprawny adres email
            'phone' => ['nullable', 'string', 'max:20'], // Może być puste, ale jeśli jest podane, to jako string
            'is_company' => ['required', 'boolean'], // Wymagane, typ logiczny
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
