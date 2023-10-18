<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title></title>

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
                padding: 0px;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				margin: auto;
				padding: 30px;
				/* border: 1px solid #eee; */
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				/* border-bottom: 1px solid #ddd; */
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				/* border-bottom: 1px solid #eee; */
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				/* border-top: 2px solid #eee; */
				font-weight: bold;
			}

            table td, table tr, table th {
                border:1px solid black;
            }
		</style>
	</head>



    
	<body>
		<div class="invoice-box">
<table class="table table-hover table-bordered" style="border:1px solid black;">
    <thead style="
    background-color: #009aad;
    color: white;
">
        <tr align="center" style="border:1px solid black;">
            <th rowspan="2" class="align-middle" style="width: 5%" background-color="blue" color="white">
                No
            </th>
            <th rowspan="2" class="align-middle" width="100%" background-color="blue" color="white">
                Customer
            </th>
            <th colspan="31" class="text-center" background-color="blue" style="text-align: center" color="white">
                Periode: januari 2022
            </th>
            <th rowspan="2" class="align-middle" width="100%" background-color="blue" color="white">
                Total
            </th>
        </tr>
        <tr style="text-align: center">
            @foreach($data['day'] as $i)
            <th class="no-tr" >
                {{ $i }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr style="border:1px solid black;">
            <td colspan="2" background-color="blue" color="white">Grand Total</td>
            @foreach ($data['day'] as $day)
                @php
                    $total = 0;
                    $hari;
                    foreach ($data['listOrder']['perTanggal'] as $perTanggal)  {
                        $hari = date('d', strtotime($perTanggal['tanggal']));
                        if ($hari == $day) 
                        {
                            $total += (int) $perTanggal['total'];
                        }
                    }
                    if ($total == 0){
                        $total = '-';
                    }
                    else{
                        $total = $total;
                    }
                @endphp

                <td align="right">
                    Rp {{ $total }}
                </td>
            @endforeach
            
                <td align="right">
                               
                   Rp {{ $data ['listOrder']['total'] }}
                </td>
        </tr>

        @foreach($data['customer'] as $i => $customer)
        <tr>
            <td align="center">
                {{ ++$i;}}
            </td>
            <td>{{ $customer['nama'] }}</td>
            
            @foreach ($data['day'] as $day)
                    @php
                        $total = 0;
                        $hari;
                        foreach ($data['listOrder']['perTanggalCustomer'] as $perTanggalCustomer)  {
                            $hari = date('d', strtotime($perTanggalCustomer['tanggal']));
                            if ($hari == $day && $customer ['id'] == $perTanggalCustomer['id_customer']) {
                                $total += (int) $perTanggalCustomer['total'];
                            }
                        }
                        if ($total == 0){
                            $total = '-';
                        }
                        else{
                            $total = $total;
                        }
                    @endphp

                    <td align="right">
                        Rp {{ $total }}
                    </td>
            @endforeach
            @php
                $totalcust = 0;
                foreach ($data['listOrder']['perCustomer'] as $perCustomer)  {
                    if ($customer ['id'] == $perCustomer['id_customer']) {
                        $totalcust += (int) $perCustomer['total'];
                    }
                }
                if ($totalcust == 0){
                    $totalcust = '-';
                }
                else{
                    $totalcust = $totalcust;
                }
            @endphp

                <td align="right">
                    Rp {{ $totalcust }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
</body>
</html>
