<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VatRate\BulkDestroyVatRate;
use App\Http\Requests\Admin\VatRate\DestroyVatRate;
use App\Http\Requests\Admin\VatRate\IndexVatRate;
use App\Http\Requests\Admin\VatRate\StoreVatRate;
use App\Http\Requests\Admin\VatRate\UpdateVatRate;
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
use Illuminate\Support\Facades\Validator;

class VatRateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVatRate $request
     * @return array|Factory|View
     */
    public function index(IndexVatRate $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VatRate::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'rate', 'description'],

            // set columns to searchIn
            ['rate', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.vat-rate.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.vat-rate.create');

        return view('admin.vat-rate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVatRate $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVatRate $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect('admin/vat-rates/create')
                ->withErrors($validator)
                ->withInput();
        }

        $sanitized = $validator->validated();

        $vatRate = VatRate::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/vat-rates'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/vat-rates');
    }


    /**
     * Display the specified resource.
     *
     * @param VatRate $vatRate
     * @throws AuthorizationException
     * @return void
     */
    public function show(VatRate $vatRate)
    {
        $this->authorize('admin.vat-rate.show', $vatRate);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VatRate $vatRate
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VatRate $vatRate)
    {
        $this->authorize('admin.vat-rate.edit', $vatRate);


        return view('admin.vat-rate.edit', [
            'vatRate' => $vatRate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVatRate $request
     * @param VatRate $vatRate
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVatRate $request, VatRate $vatRate)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VatRate
        $vatRate->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vat-rates'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/vat-rates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVatRate $request
     * @param VatRate $vatRate
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVatRate $request, VatRate $vatRate)
    {
        $vatRate->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVatRate $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVatRate $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VatRate::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
