<table>
    <thead>
        <tr align="center">
            <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                Menu
            </th>
            <th colspan="31" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                Periode
            </th>
            <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                Total
            </th>
        </tr>
        <tr>
            @foreach($data['day'] as $day)
            <td style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                {{$day}}
            </td>
            @endforeach

        </tr>
    </thead>

    <tbody>
        <tr style="background: #fbfbfb">
            <td style="font-weight: bold; border: 1px solid lightgrey;">
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
            <td style="text-align: center; border: 1px solid lightgrey; font-weight: bold;">
            {{$total}}
            </td>
            @endforeach

            {{-- @foreach($data['listOrder']['total'] as $total) --}}
            <td style="font-weight: bold; border: 1px solid lightgrey;" >
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
            <td colspan="33" style="border: 1px solid lightgrey; font-weight: bold;">Snack</td>
            </tr>
            @foreach($data['listsnack'] as $snack)
            <tr>
                <td style="border: 1px solid lightgrey;">{{$snack['nama']}}</td>
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
                <td style="border: 1px solid lightgrey;">{{$total}}</td>
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
                <td style="border: 1px solid lightgrey;">{{$total}}</td>
            </tr>
            @endforeach
            


            <tr>
                <td colspan="32" style="border: 1px solid lightgrey; font-weight: bold;">Total Snack</td>
                @php 
                $total = 0;
                foreach($data['listOrder']['perKategori'] as $val){
                    if($val['kategori'] == 'snack'){
                        $total = $val['total'];
                    }
                }

                $total = $total;
                @endphp
                <td style="border: 1px solid lightgrey; font-weight: bold;">{{$total}}</td>
            </tr>
            @endif
            

            @if($data['kategori'] == 'food' || $data['kategori'] == '')
            <tr
                style="
                    background: #eee;
                "
            >
            <td colspan="33" style="border: 1px solid lightgrey; font-weight: bold;">Food</td>
            </tr>
            @foreach($data['listfood'] as $food)
            <tr>
                <td style="border: 1px solid lightgrey;">{{$food['nama']}}</td>

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
                <td style="border: 1px solid lightgrey;">{{$total}}</td>
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
                <td style="border: 1px solid lightgrey;">{{$total}}</td>

            </tr>
            @endforeach
            <tr style="font-weight: 700">
                <td colspan="32" style="border: 1px solid lightgrey; font-weight: bold;">Total Food</td>
                @php 
                $total = 0;
                foreach($data['listOrder']['perKategori'] as $val){
                    if($val['kategori'] == 'food'){
                        $total = $val['total'];
                    }
                }

                $total = $total;
                @endphp
                <td style="border: 1px solid lightgrey; font-weight: bold;">{{$total}}</td>
            </tr>
            @endif

            @if($data['kategori'] == 'drink' || $data['kategori'] == '')
            <tr
                style="
                    background: #eee;
                    font-weight: 700;
                "
            >

            <td colspan="33" style="border: 1px solid lightgrey; font-weight: bold;">Drink</td>

            @foreach($data['listdrink'] as $drink)
            <tr>
            <td style="border: 1px solid lightgrey;">{{$drink['nama']}}</td>

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
            <td style="border: 1px solid lightgrey;">{{$total}}</td>
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
            <td style="border: 1px solid lightgrey;">{{$total}}</td>
            </tr>
            @endforeach
            <tr style="font-weight: 700">
                <td colspan="32" style="border: 1px solid lightgrey; font-weight: bold;">Total Drink</td>
                @php 
                $total = 0;
                foreach($data['listOrder']['perKategori'] as $val){
                    if($val['kategori'] == 'drink'){
                        $total = $val['total'];
                    }
                }

                $total = $total;
                @endphp
                <td style="border: 1px solid lightgrey; font-weight: bold;">{{$total}}</td>
            </tr>
            @endif
    </tbody>
</table>