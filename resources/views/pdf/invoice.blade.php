<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Faktura VAT nr {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .header {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .flex
        {
            display: inline;
        }

        .flex section
        {
            width: 40%;
        }
    </style>
</head>
<body>
    <div class="header">
        Faktura VAT nr {{ $invoice->invoice_number }}
    </div>

    <p>Data wystawienia: {{ $invoice->issue_date }}</p>
    <div class="flex">
        <section>
            <h3>Dane Sprzedawcy:</h3>
            <p>Przykładowa firma sp. z o.o.</p>
            <p>NIP: 123456789</p>
            <p>Adres: os. Bardzo fajne 64-300 Nowy Tomyśl</p>
        </section>

        <section>
            <h3>Dane Nabywcy:</h3>
            <p>{{ $invoice->customer->name }}</p>
            <p>NIP: {{ $invoice->customer->vat_id }}</p>
            <p>Adres: {{ $invoice->customer->address }}</p>
        </section>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nazwa towaru/usługi</th>
                <th>Ilość</th>
                <th>Cena netto</th>
                <th>Stawka VAT</th>
                <th>Wartość netto</th>
                <th>Kwota VAT</th>
                <th>Wartość brutto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} zł</td>
                    <td>{{ $item->vatRate->rate }}%</td>
                    <td>{{ number_format($item->quantity * $item->unit_price, 2) }} zł</td>
                    <td>{{ number_format($item->quantity * $item->unit_price * ($item->vatRate->rate / 100), 2) }} zł</td>
                    <td>{{ number_format($item->quantity * $item->unit_price * (1 + $item->vatRate->rate / 100), 2) }} zł</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Suma:</th>
                <th>{{ number_format($totals['total_netto'], 2) }} zł</th>
                <th>{{ number_format($totals['total_brutto'] - $totals['total_netto'], 2) }} zł</th>
                <th>{{ number_format($totals['total_brutto'], 2) }} zł</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
