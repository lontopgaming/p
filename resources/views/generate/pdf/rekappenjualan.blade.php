{{-- <!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <p>{{ $description }}</p>

    <br>

    <p>Put your text here.</p>

    <p>Place your dynamic content here.</p>

    <br>

    <p style="text-align: center;">{!! $footer !!}</p>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Rekap Penjualan PDF</title>
        <!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: black;
                padding: 0px;
			}

			.invoice-box {
				margin: auto;
				padding: 30px;
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: center;
                border: 1px solid black;
                border-collapse: collapse;
                
			}

            .invoice-box table thead tr th {
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                border: 1px solid black;
                background: #009aad;
                color: white;

			}

            .invoice-box table tbody tr td {
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                border: 1px solid black;
			}
		</style>
	</head>

<body>
    <div class="invoice-box">
        <table>
            <thead>
                    <tr align="center">
                        <th
                            style="width: 5%"
                            rowspan="2"
                            
                        >
                            No
                        </th>
                        <th rowspan="2">
                            No Struk
                        </th>
                        <th rowspan="2">
                            Customer
                        </th>
                        <th rowspan="2">
                            Tanggal
                        </th>
                        <th rowspan="2">
                            Menu
                        </th>
                        <th rowspan="2">
                            Jumlah
                        </th>
                        <th rowspan="2">
                            Harga
                        </th>
                        <th rowspan="2">
                            Total
                        </th>
                        <th colspan="2">
                            Promo
                        </th>
                        <th rowspan="2">
                            Total Bayar
                        </th>
                    </tr>
                    <tr align="center">
                        <th >Diskon</th>
                        <th>Voucher</th>
                    </tr>
                </thead>
            <tbody>
            @foreach($data as $no => $val)
            <tr>
                    <td  class="align-middle" rowspan="{{count($val->order)}}">{{ ++$no }}</td>
                    <td  class="align-middle" rowspan="{{count($val->order)}}">{{ $val->no_struk }}</td>
                    <td  class="align-middle" rowspan="{{count($val->order)}}">{{ $val->nama_customer }}</td>
                    <td  class="align-middle" rowspan="{{count($val->order)}}">{{ \Carbon\Carbon::parse($val->tanggal)->format('d-m-Y') }}</td>
                    <td class="align-middle" >{{ $val->order[0]->nama_item }}</td>
                    <td class="align-middle" > {{ $val->order[0]->jumlah }}</td>
                    <td class="align-middle" >Rp {{ $val->order[0]->harga }}</td>
                    <td class="align-middle" >Rp {{ $val->order[0]->total }}</td>
                    @if($val->diskon == 0 || $val->diskon == null || $val->diskon == 0 || $val->diskon == null)
                        <td rowspan="{{count($val->order)}}">-</td>
                    @endif

                    @if($val->diskon != 0 || $val->diskon != null || $val->diskon != 0 || $val->diskon != null)
                    <td rowspan="{{count($val->order)}}">{{ $val->diskon }} %</td>
                    @endif

                    @if($val->potongan == null || $val->potongan == 0)
                    <td rowspan="{{count($val->order)}}">-</td>
                    @endif
                    
                    @if($val->potongan != null || $val->potongan != 0)
                    <td rowspan="{{count($val->order)}}">Rp {{$val->potongan}}</td>
                    @endif

                    <td rowspan="{{count($val->order)}}">Rp {{ $val->total_bayar }} </td>
                </tr>
                @for($i=1; $i<count($val->order); $i++)
                <tr>
                    <td class="align-middle">{{ $val->order[$i]->nama_item }}</td>
                    <td class="align-middle">{{ $val->order[$i]->jumlah }}</td>
                    <td class="align-middle">Rp {{ $val->order[$i]->harga }}</td>
                    <td class="align-middle">Rp {{ $val->order[$i]->total }}</td>
                </tr>
                @endfor 
            
            @endforeach
            </tbody>
        </table>
        </div>
	</body>
</html>