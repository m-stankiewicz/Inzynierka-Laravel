@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.vat-rate.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <vat-rate-form
            :action="'{{ url('admin/vat-rates') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.vat-rate.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.vat-rate.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </vat-rate-form>

        </div>

        </div>

    
@endsection