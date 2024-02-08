<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invoice\BulkDestroyInvoice;
use App\Http\Requests\Admin\Invoice\DestroyInvoice;
use App\Http\Requests\Admin\Invoice\IndexInvoice;
use App\Http\Requests\Admin\Invoice\StoreInvoice;
use App\Http\Requests\Admin\Invoice\UpdateInvoice;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\VatRate;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\InvoiceSeries;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexInvoice $request
     * @return array|Factory|View
     */
    public function index(IndexInvoice $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Invoice::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'invoice_number'],

            // set columns to searchIn
            ['id']
        );

        // Zbieranie dodatkowych danych
        $data->each(function ($item) {
            $item->total_netto = $item->items->sum(function ($invoiceItem) {
                return $invoiceItem->unit_price * $invoiceItem->quantity;
            });
    
            $item->total_brutto = $item->items->sum(function ($invoiceItem) {
                $vatRate = $invoiceItem->vatRate->rate / 100;
                return $invoiceItem->unit_price * $invoiceItem->quantity * (1 + $vatRate);
            });
    
            $item->customer = $item->customer ? $item->customer->name : null;
        });
    
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
    
        return view('admin.invoice.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.invoice.create');

        return view('admin.invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInvoice $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreInvoice $request)
    {
        $sanitized = $request->getSanitized();

        DB::beginTransaction();

        try {
            $invoice = Invoice::create($sanitized);

            if (isset($sanitized['invoiceItems']) && is_array($sanitized['invoiceItems'])) {
                foreach ($sanitized['invoiceItems'] as $item) {
                    $invoiceItem = new InvoiceItem($item);
                    $invoice->items()->save($invoiceItem);
                }
            }

            $invoice->invoice_number = $this->generateInvoiceNumber(Carbon::parse($invoice->issue_date), $invoice->invoice_series_id);
            $invoice->save();

            DB::commit();

            if ($request->ajax()) {
                return ['redirect' => url('admin/invoices'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
            }

            return redirect('admin/invoices');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;  // Możesz również dodać obsługę błędów, aby zwrócić odpowiedź dla użytkownika
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @throws AuthorizationException
     * @return void
     */
    public function show(Invoice $invoice)
    {
        $this->authorize('admin.invoice.show', $invoice);

        // TODO your code goes here
    }

    public function generatePDF($invoiceId)
    {
        $invoice = Invoice::with(['customer', 'items.vatRate'])->findOrFail($invoiceId);
        $data = [
            'invoice' => $invoice,
            'totals' => $invoice->calculateTotals(),
        ];

        $pdf = PDF::loadView('pdf.invoice', $data);
        
        return $pdf->download('faktura-' . $invoice->invoice_number . '.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('admin.invoice.edit', $invoice);
        $invoice->load('items');
        $invoiceItemsFormatted = $invoice->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'unit' => $item->unit,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'vat_rate_id' => $item->vat_rate_id,
            ];
        });

        return view('admin.invoice.edit', [
            'invoice' => $invoice,
            'invoiceItems' => $invoiceItemsFormatted,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInvoice $request
     * @param Invoice $invoice
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateInvoice $request, Invoice $invoice)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Invoice
        $invoice->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/invoices'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyInvoice $request
     * @param Invoice $invoice
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyInvoice $request, Invoice $invoice)
    {
        $invoice->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyInvoice $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyInvoice $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Invoice::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function generateInvoiceNumber($issueDate, $seriesId)
    {
        // Format daty
        $yearFull = $issueDate->format('Y'); // 2024
        $yearShort = $issueDate->format('y'); // 24
        $month = $issueDate->format('m'); // 02

        // Pobierz obiekt InvoiceSeries
        $series = InvoiceSeries::findOrFail($seriesId);
        $pattern = $series->pattern;
        // Pobierz ostatnie ID z trackera
        $lastId = $series->getLastIdForSeries($issueDate);
        
        // Podmień tokeny w wzorcu
        $invoiceNumber = str_replace(['%R%', '%r%', '%m%', '%idm%', '%idy%'], 
                                    [$yearFull, $yearShort, $month, $lastId['monthly_id'], $lastId['yearly_id']], 
                                    $pattern);

        return $invoiceNumber;
    }
}
