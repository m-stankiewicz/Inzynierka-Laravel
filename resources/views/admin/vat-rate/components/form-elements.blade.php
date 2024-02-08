<div class="form-group row align-items-center">
    <label for="rate" class="col-md-4 col-form-label text-md-right">{{ trans('admin.vat-rate.columns.rate') }}</label>
    <div class="col-md-8">
        <input type="number" id="rate" name="rate" class="form-control" v-model="form.rate" step="0.01" :class="{'form-control-danger': errors.has('rate'), 'form-control-success': fields.rate && fields.rate.valid}">
        <div v-if="errors.has('rate')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('rate') }}</div>
    </div>
</div>
<div class="form-group row align-items-center">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ trans('admin.vat-rate.columns.description') }}</label>
    <div class="col-md-8">
        <input type="text" id="description" name="description" class="form-control" v-model="form.description" :class="{'form-control-danger': errors.has('description'), 'form-control-success': fields.description && fields.description.valid}">
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>
