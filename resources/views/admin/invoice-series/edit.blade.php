@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.invoice-series.actions.edit', ['name' => $invoiceSeries->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <invoice-series-form
                :action="'{{ $invoiceSeries->resource_url }}'"
                :data="{{ $invoiceSeries->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.invoice-series.actions.edit', ['name' => $invoiceSeries->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.invoice-series.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </invoice-series-form>

        </div>
    
</div>

@endsection