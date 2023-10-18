        <table>
            <thead>
                    <tr align="center">
                        <th
                        style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;"
                            rowspan="2"
                            
                        >
                            No
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            No Struk
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Customer
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Tanggal
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Menu
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Jumlah
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Harga
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Total
                        </th>
                        <th colspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Promo
                        </th>
                        <th rowspan="2" style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">
                            Total Bayar
                        </th>
                    </tr>
                    <tr align="center">
                        <th style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">Diskon</th>
                        <th style="text-align: center; background: #009aad; color: white; border: 1px solid lightgrey; font-weight: bold;">Voucher</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $no => $val)
                        <tr>
                            <td class="align-middle"  rowspan="{{count($val['order'])}}">{{ ++$no }}</td>
                            <td class="align-middle"  rowspan="{{count($val['order'])}}">{{ $val['no_struk'] }}</td>
                            <td class="align-middle"  rowspan="{{count($val['order'])}}">{{ $val['nama_customer'] }}</td>
                            <td class="align-middle"  rowspan="{{count($val['order'])}}">{{ \Carbon\Carbon::parse($val['tanggal'])->format('d-m-Y') }}</td>
                            <td class="align-middle" >{{ $val['order'][0]['nama_item'] }}</td>
                            <td class="align-middle" >{{ $val['order'][0]['jumlah'] }}</td>
                            <td class="align-middle" >Rp {{ $val['order'][0]['harga'] }}</td>
                            <td class="align-middle" >Rp {{ $val['order'][0]['total'] }}</td>
                            @if($val['diskon'] == 0 || $val['diskon'] == null || $val['diskon'] == 0 || $val['diskon'] == null)
                                <td rowspan="{{count($val['order'])}}">-</td>
                            @endif
                    
                            @if($val['diskon'] != 0 || $val['diskon'] != null || $val['diskon'] != 0 || $val['diskon'] != null)
                                <td rowspan="{{count($val['order'])}}">{{ $val['diskon'] }} %</td>
                            @endif
                    
                            @if($val['potongan'] == null || $val['potongan'] == 0)
                                <td rowspan="{{count($val['order'])}}">-</td>
                            @endif
                                        
                            @if($val['potongan'] != null || $val['potongan'] != 0)
                                <td rowspan="{{count($val['order'])}}">Rp {{ $val['potongan'] }}</td>
                            @endif
                    
                            <td rowspan="{{count($val['order'])}}">Rp {{ $val['total_bayar'] }} </td>
                        </tr>
                        @for($i=1; $i<count($val['order']); $i++)
                            <tr>
                                <td class="align-middle">{{ $val['order'][$i]['nama_item'] }}</td>
                                <td class="align-middle">{{ $val['order'][$i]['jumlah'] }}</td>
                                <td class="align-middle">Rp {{ $val['order'][$i]['harga'] }}</td>
                                <td class="align-middle">Rp {{ $val['order'][$i]['total'] }}</td>
                            </tr>
                        @endfor 
                    @endforeach
                    </tbody>
                    
        </table>
      