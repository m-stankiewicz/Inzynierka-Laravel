<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceSeries\BulkDestroyInvoiceSeries;
use App\Http\Requests\Admin\InvoiceSeries\DestroyInvoiceSeries;
use App\Http\Requests\Admin\InvoiceSeries\IndexInvoiceSeries;
use App\Http\Requests\Admin\InvoiceSeries\StoreInvoiceSeries;
use App\Http\Requests\Admin\InvoiceSeries\UpdateInvoiceSeries;
use App\Models\InvoiceSeries;
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

class InvoiceSeriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexInvoiceSeries $request
     * @return array|Factory|View
     */
    public function index(IndexInvoiceSeries $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(InvoiceSeries::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'description', 'pattern'],

            // set columns to searchIn
            ['name', 'description', 'pattern']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.invoice-series.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.invoice-series.create');

        return view('admin.invoice-series.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInvoiceSeries $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreInvoiceSeries $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the InvoiceSeries
        $invoiceSeries = InvoiceSeries::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/invoice-series'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/invoice-series');
    }

    /**
     * Display the specified resource.
     *
     * @param InvoiceSeries $invoiceSeries
     * @throws AuthorizationException
     * @return void
     */
    public function show(InvoiceSeries $invoiceSeries)
    {
        $this->authorize('admin.invoice-series.show', $invoiceSeries);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InvoiceSeries $invoiceSeries
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(InvoiceSeries $invoiceSeries)
    {
        $this->authorize('admin.invoice-series.edit', $invoiceSeries);


        return view('admin.invoice-series.edit', [
            'invoiceSeries' => $invoiceSeries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInvoiceSeries $request
     * @param InvoiceSeries $invoiceSeries
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateInvoiceSeries $request, InvoiceSeries $invoiceSeries)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values InvoiceSeries
        $invoiceSeries->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/invoice-series'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/invoice-series');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyInvoiceSeries $request
     * @param InvoiceSeries $invoiceSeries
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyInvoiceSeries $request, InvoiceSeries $invoiceSeries)
    {
        $invoiceSeries->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyInvoiceSeries $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyInvoiceSeries $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    InvoiceSeries::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
