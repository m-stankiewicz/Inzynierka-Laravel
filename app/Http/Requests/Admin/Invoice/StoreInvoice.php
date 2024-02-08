<?php

namespace App\Http\Requests\Admin\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreInvoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.invoice.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'invoice_series_id' => ['required', 'exists:invoice_series,id'],
            'invoiceItems.*.name' => ['required', 'string', 'max:255'],
            'invoiceItems.*.unit' => ['required', 'string'],
            'invoiceItems.*.unit_price' => ['required', 'numeric', 'min:0'],
            'invoiceItems.*.vat_rate_id' => ['required', 'exists:vat_rates,id'],
            'invoiceItems.*.quantity' => ['required', 'numeric', 'min:1'],
            'invoiceItems.*.description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'issue_date' => ['required', 'date'],
            'payment_received_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
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
