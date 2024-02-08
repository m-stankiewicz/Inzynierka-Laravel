<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('admin.customer.columns.name') }}</label>
    <div class="col-md-8">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.customer.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
    <label for="address" class="col-md-4 col-form-label text-md-right">{{ trans('admin.customer.columns.address') }}</label>
    <div class="col-md-8">
        <input type="text" v-model="form.address" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('address'), 'form-control-success': fields.address && fields.address.valid}" id="address" name="address" placeholder="{{ trans('admin.customer.columns.address') }}">
        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('vat_id'), 'has-success': fields.vat_id && fields.vat_id.valid }">
    <label for="vat_id" class="col-md-4 col-form-label text-md-right">{{ trans('admin.customer.columns.vat_id') }}</label>
    <div class="col-md-8">
        <input type="text" v-model="form.vat_id" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('vat_id'), 'form-control-success': fields.vat_id && fields.vat_id.valid}" id="vat_id" name="vat_id" placeholder="{{ trans('admin.customer.columns.vat_id') }}">
        <div v-if="errors.has('vat_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('vat_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('admin.customer.columns.email') }}</label>
    <div class="col-md-8">
        <input type="email" v-model="form.email" v-validate="'email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.customer.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ trans('admin.customer.columns.phone') }}</label>
    <div class="col-md-8">
        <input type="text" v-model="form.phone" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.customer.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="customer_type" class="col-md-4 col-form-label text-md-right">{{ trans('admin.customer.columns.customer_type') }}</label>
    <div class="col-md-8">
        <select class="form-control" id="customer_type" name="is_company" v-model="form.is_company">
            <option value="0">{{ trans('admin.customer.columns.individual') }}</option>
            <option value="1">{{ trans('admin.customer.columns.company') }}</option>
        </select>
        <div v-if="errors.has('is_company')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_company') }}</div>
    </div>
</div>