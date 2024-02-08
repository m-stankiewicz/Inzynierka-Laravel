{{-- Wybór Klienta --}}
<div class="form-group">
    <label for="customer_id">Klient</label>
    <select class="form-control" id="customer_id" name="customer_id" v-model="form.customer_id">
        @foreach(App\Models\Customer::orderBy('name')->get() as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>
</div>

{{-- Wybór Serii Faktur --}}
<div class="form-group">
    <label for="invoice_series_id">Seria Faktury</label>
    <select class="form-control" id="invoice_series_id" name="invoice_series_id" v-model="form.invoice_series_id">
        @foreach(App\Models\InvoiceSeries::all() as $series)
            <option value="{{ $series->id }}">{{ $series->name }} ({{ $series->pattern }})</option>
        @endforeach
    </select>
</div>

<div v-for="(item, index) in form.invoiceItems" :key="index" class="row mb-3">
    <div class="col-md-2">
        <label>Nazwa</label>
        <input type="text" v-model="item.name" class="form-control mb-2">
    </div>
    <div class="col-md-2">
        <label>Jednostka</label>
        <input type="text" v-model="item.unit" class="form-control mb-2">
    </div>
    <div class="col-md-2">
        <label>Cena netto za jednostkę</label>
        <input type="number" v-model="item.unit_price" class="form-control mb-2">
    </div>
    <div class="col-md-2">
        <label>Stawka VAT</label>
        <select v-model="item.vat_rate_id" name="vat_rate_id" class="form-control mb-2">
            @foreach(App\Models\VatRate::all() as $rate)
                <option value="{{ $rate->id }}">{{ $rate->rate }} %</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>Ilość</label>
        <input type="number" v-model="item.quantity" class="form-control mb-2">
    </div>
    <div class="col-md-2">
        <button type="button" @click.prevent="removeInvoiceItem(index)" class="btn btn-danger mb-2">Usuń</button>
    </div>
</div>



<button @click.prevent="addInvoiceItem" class="btn btn-primary mt-2 mb-2">Dodaj pozycję</button>


{{-- Opis Faktury --}}
<div class="form-group">
    <label for="description">Opis</label>
    <textarea class="form-control" id="description" name="description" v-model="form.description"></textarea>
</div>

{{-- Data Otrzymania Płatności --}}
<div class="form-group">
    <label for="issue_date">Data Wystawienia Faktury</label>
    <input type="date" class="form-control" id="issue_date" name="issue_date" v-model="form.issue_date">
</div>

{{-- Data Otrzymania Płatności --}}
<div class="form-group">
    <label for="payment_received_date">Data Otrzymania Płatności</label>
    <input type="date" class="form-control" id="payment_received_date" name="payment_received_date" v-model="form.payment_received_date">
</div>