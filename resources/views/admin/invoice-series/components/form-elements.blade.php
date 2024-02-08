{{-- Pole Name --}}
<div class="form-group row align-items-center">
    <label for="name" class="col-md-4 col-form-label text-md-right">Nazwa serii</label>
    <div class="col-md-8">
        <input type="text" id="name" name="name" class="form-control" v-model="form.name" required>
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

{{-- Pole Description --}}
<div class="form-group row align-items-center">
    <label for="description" class="col-md-4 col-form-label text-md-right">Opis</label>
    <div class="col-md-8">
        <textarea id="description" name="description" class="form-control" v-model="form.description"></textarea>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>

{{-- Pole Pattern --}}
<div class="form-group row align-items-center">
    <label for="pattern" class="col-md-4 col-form-label text-md-right">Wzorzec</label>
    <div class="col-md-8">
        <input type="text" id="pattern" name="pattern" class="form-control" v-model="form.pattern" required>
        <div v-if="errors.has('pattern')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pattern') }}</div>
    </div>
</div>

{{-- Instrukcje dla Pattern --}}
<div class="form-group row">
    <div class="col-md-8 offset-md-4">
        <p>Użyj następujących symboli w wzorcu:</p>
        <ul>
            <li>%R% - Rok (2024)</li>
            <li>%r% - Rok (24)</li>
            <li>%m% - Miesiąc (02)</li>
            <li>%idm% - Miesięczne ID</li>
            <li>%idy% - Rocznego ID</li>
        </ul>
    </div>
</div>