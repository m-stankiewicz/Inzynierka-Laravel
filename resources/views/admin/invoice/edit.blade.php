@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.invoice.actions.edit', ['name' => $invoice->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <invoice-form
                :action="'{{ $invoice->resource_url }}'"
                :data="{{ json_encode(['invoice' => $invoice, 'items' => $invoiceItems]) }}"
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.invoice.actions.edit', ['name' => $invoice->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.invoice.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </invoice-form>

        </div>
    
</div>

@endsection