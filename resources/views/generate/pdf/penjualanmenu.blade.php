<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title></title>
  <style>
  table td, table tr, table th{
    border:1px solid black;
  }
  </style>
<body>
<table style="border:1px black;">
    <thead>
        <tr align="center">
            <th rowspan="2" style="text-align: center; background: #009aad; color: white;  ; font-weight: bold;">
                Menu
            </th>
            <th colspan="31" style="text-align: center; background: #009aad; color: white;  ; font-weight: bold;">
                Periode
            </th>
            <th rowspan="2" style="text-align: center; background: #009aad; color: white;  ; font-weight: bold;">
                Total
            </th>
        </tr>
        <tr>
            @foreach($data['day'] as $day)
            <td style="text-align: center; background: #009aad; color: white;  ; font-weight: bold;">
                {{$day}}
            </td>
            @endforeach

        </tr>
    </thead>

    <tbody>
        <tr style="background: #fbfbfb">
            <td style="font-weight: bold;  ;">
                GRAND TOTAL
            </td>
            @foreach($data['day'] as $day)
            @php 
            $total=0;
            $dayDate;
            foreach($data['listOrder']['perTanggal'] as $val){
                $dayDate = date('d', strtotime($val['tanggal']));
                                                                                    
                if($dayDate == $day){
                    $total += (int) $val['total'];
                }
            }

            if($total == 0){
                $total = '0';
            }else{
                $total = $total;
            }
            @endphp
            <td style="text-align: center;  ; font-weight: bold;">
            Rp {{$total}}
            </td>
            @endforeach

            {{-- @foreach($data['listOrder']['total'] as $total) --}}
            <td style="font-weight: bold;  ;" >
            {{$data['listOrder']['total']}}
            </td>
            {{-- @endforeach --}}
        </tr>

        @if($data['kategori'] == 'snack' || $data['kategori'] == '')
            <tr
                style="
                    background: #eee;
                "
            >
            <td colspan="33" style=" ; font-weight: bold;">Snack</td>
            </tr>
            @foreach($data['listsnack'] as $snack)
            <tr>
                <td style=" ;">{{$snack['nama']}}</td>
                @foreach($data['day'] as $day)
                @php 
                $total=0;
                $dayDate;
                foreach($data['listOrder']['perTanggalMenu'] as $val){
                    $dayDate = date('d', strtotime($val['tanggal']));

                    if($dayDate == $day && $snack['itemid'] == $val['id_menu']){
                        $total += (int) $val['total'];
                    }
                }
                
                    if ($total == 0) {
                        $total = '0';
                    } else {
                        $total = $total;
                    }

                @endphp
                <td style=" ;">Rp {{$total}}</td>
                @endforeach

                @php 
                $total=0;
                foreach($data['listOrder']['perMenu'] as $val){
                    if($snack['itemid'] == $val['id_menu']){
                        $total += (int) $val['total'];
                    }
                }
                
                    if ($total == 0) {
                        $total = '0';
                    } else {
                        $total = $total;
                    }

                @endphp
                <td style=" ;">Rp {{$total}}</td>
            </tr>
            @endforeach
            


            <tr>
                <td colspan="32" style=" ; font-weight: bold;">Total Snack</td>
                @php 
                $total = 0;
                foreach($data['listOrder']['perKategori'] as $val){
                    if($val['kategori'] == 'snack'){
                        $total = $val['total'];
                    }
                }

                $total = $total;
                @endphp
                <td style=" ; font-weight: bold;">Rp {{$total}}</td>
            </tr>
            @endif
            

            @if($data['kategori'] == 'food' || $data['kategori'] == '')
            <tr
                style="
                    background: #eee;
                "
            >
            <td colspan="33" style=" ; font-weight: bold;">Food</td>
            </tr>
            @foreach($data['listfood'] as $food)
            <tr>
                <td style=" ;">{{$food['nama']}}</td>

                @foreach($data['day'] as $day)
                @php 
                $total=0;
                $dayDate;
                foreach($data['listOrder']['perTanggalMenu'] as $val){
                    $dayDate = date('d', strtotime($val['tanggal']));

                    if($dayDate == $day && $food['itemid'] == $val['id_menu']){
                        $total += (int) $val['total'];
                    }
                }
                
                    if ($total == 0) {
                        $total = '0';
                    } else {
                        $total = $total;
                    }

                @endphp
                <td style=" ;">{{$total}}</td>
                @endforeach

                @php 
                $total=0;
                foreach($data['listOrder']['perMenu'] as $val){
                    if($food['itemid'] == $val['id_menu']){
                        $total += (int) $val['total'];
                    }
                }
                
                    if ($total == 0) {
                        $total = '0';
                    } else {
                        $total = $total;
                    }

                @endphp
                <td style=" ;">Rp {{$total}}</td>

            </tr>
            @endforeach
            <tr style="font-weight: 700">
                <td colspan="32" style=" ; font-weight: bold;">Total Food</td>
                @php 
                $total = 0;
                foreach($data['listOrder']['perKategori'] as $val){
                    if($val['kategori'] == 'food'){
                        $total = $val['total'];
                    }
                }

                $total = $total;
                @endphp
                <td style=" ; font-weight: bold;">Rp {{$total}}</td>
            </tr>
            @endif

            @if($data['kategori'] == 'drink' || $data['kategori'] == '')
            <tr
                style="
                    background: #eee;
                    font-weight: 700;
                "
            >

            <td colspan="33" style=" ; font-weight: bold;">Drink</td>

            @foreach($data['listdrink'] as $drink)
            <tr>
            <td style=" ;">{{$drink['nama']}}</td>

            @foreach($data['day'] as $day)
            @php 
            $total=0;
            $dayDate;
            foreach($data['listOrder']['perTanggalMenu'] as $val){
                $dayDate = date('d', strtotime($val['tanggal']));

                if($dayDate == $day && $drink['itemid'] == $val['id_menu']){
                    $total += (int) $val['total'];
                }
            }
            
                if ($total == 0) {
                    $total = '0';
                } else {
                    $total = $total;
                }

            @endphp
            <td style=" ;">Rp {{$total}}</td>
            @endforeach

            @php 
            $total=0;
            foreach($data['listOrder']['perMenu'] as $val){
                if($drink['itemid'] == $val['id_menu']){
                    $total += (int) $val['total'];
                }
            }
            
                if ($total == 0) {
                    $total = '0';
                } else {
                    $total = $total;
                }

            @endphp
            <td style=" ;">Rp {{$total}}</td>
            </tr>
            @endforeach
            <tr style="font-weight: 700">
                <td colspan="32" style=" ; font-weight: bold;">Total Drink</td>
                @php 
                $total = 0;
                foreach($data['listOrder']['perKategori'] as $val){
                    if($val['kategori'] == 'drink'){
                        $total = $val['total'];
                    }
                }

                $total = $total;
                @endphp
                <td style=" ; font-weight: bold;">Rp {{$total}}</td>
            </tr>
            @endif
    </tbody>
</table>

</body>
</html>