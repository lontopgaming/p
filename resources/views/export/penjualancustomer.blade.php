        <table class="table table-hover table-bordered">
            <thead style="
            background-color: #009aad;
            color: white;
        ">
                <tr align="center">
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
                <tr>
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
                            {{ $total }}
                        </td>
                    @endforeach
                    
                        <td align="right">
                                       
                            {{ $data ['listOrder']['total'] }}
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
                                {{ $total }}
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
                            {{ $totalcust }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
