<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceSeries;
use Illuminate\Support\Facades\DB;
use App\Models\VatRate;
use App\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function getAllSeries()
    {
        $invoiceSeries = InvoiceSeries::all();

        return response()->json($invoiceSeries);
    }

    public function customersList()
    {
        $customer = Customer::all();

        return response()->json($customer);
    }

    public function customerInfo($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($customer);
    }

    public function getVatRates(Request $request)
    {
        $vatRates = VatRate::all(['id', 'rate', 'description']);
        return response()->json($vatRates);
    }

    public function storeInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'invoice_series_id' => 'required|exists:invoice_series,id',
            'invoiceItems.*.name' => 'required|string|max:255',
            'invoiceItems.*.unit' => 'required|string',
            'invoiceItems.*.unit_price' => 'required|numeric|min:0',
            'invoiceItems.*.vat_rate_id' => 'required|exists:vat_rates,id',
            'invoiceItems.*.quantity' => 'required|numeric|min:1',
            'invoiceItems.*.description' => 'nullable|string',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'payment_received_date' => 'nullable|date|after_or_equal:issue_date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $invoice = new Invoice([
                'customer_id' => $request->customer_id,
                'invoice_series_id' => $request->invoice_series_id,
                'issue_date' => $request->issue_date,
                'description' => $request->description ?? 'Brak',
            ]);
            $invoice->save();

            foreach ($request->invoiceItems as $item) {
                $invoiceItem = new InvoiceItem($item);
                $invoice->invoiceItems()->save($invoiceItem);
            }


            DB::commit();
            return response()->json(['message' => 'Faktura została pomyślnie utworzona.', 'invoice' => $invoice->id], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Wystąpił błąd podczas tworzenia faktury.', 'details' => $e->getMessage()], 500);
        }
    }

    public function storeCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'vat_id' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'is_company' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = new Customer($validator->validated());

        $customer->save();

        return response()->json(['message' => 'Klient został pomyślnie utworzony.', 'customer_id' => $customer->id], 201);
    }

    public function customerInfoByVatNumber($vatNumber)
    {
        $customer = Customer::where('vat_id', $vatNumber)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($customer);
    }
}
