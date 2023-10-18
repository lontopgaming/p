
import { Component, OnInit } from '@angular/core';
import { CustomerService } from '../../customers/services/customer.service';
import { DetailOrderService } from '../../detail_order/detail-order.service';
import { ItemService } from '../../items/services/item.service';
import { OrderService } from '../../order/order.service';
import { PenjualanCustomerService } from '../service/penjualan-customer.service';


@Component({
  selector: 'app-penjualan-customer',
  templateUrl: './penjualan-customer.component.html',
  styleUrls: ['./penjualan-customer.component.scss']
})
export class PenjualanCustomerComponent implements OnInit {
  numbers:Array<any> = [];
  listperTanggalCustomer: any = [];
  listReportCustomer: any = [];
  listperTanggal: any = [];
  listperCustomer: any = [];
  listReportTotal: any;
  listNama: any = [];
  periode: '';
  id_customer: any;
  nama: any;  
  customer: any;
  list: any;

  constructor(
    private penjualanService: PenjualanCustomerService,
    private itemService: ItemService,
    private customerService: CustomerService
  ) {
    this.numbers = Array.from({length:31},(v,k)=>k+1);
   }

  ngOnInit(): void {
    this.getNama()
    this.getReport('')
  }

  getReport(customer){
    let params = {
      customer: customer ?? '',
      periode: this.periode ?? '',
    };
    if(customer == 'all'){
      params = {
        customer: '',
        periode: this.periode ?? '',
      }
    }

    this.penjualanService.getpenjualancustomer(params).subscribe((res: any) => {
        this.listperTanggalCustomer = res.data.list.perTanggalCustomer;
        // this.listReportCustomer = res.data.list.perCustomer;
        this.listperTanggal = res.data.list.perTanggal;
        this.listperCustomer = res.data.list.perCustomer;
        this.listReportTotal = res.data.list.total;
        
    }, (err: any) => {
        console.log(err);
    });
  }

  getNama(){
    const params = {
      customer: ''
    }
    this.customerService.getCustomers(params).subscribe((res: any) => {
      this.listNama = res.data.list;
      console.log(this.listNama);
    }, (err: any) => {
      console.log(err);
    })
  }

  format(nominal){
    if(nominal > 0){
      var	number_string = nominal.toString(),
      sisa 	= number_string.length % 3,
      rupiah 	= number_string.substr(0, sisa),
      ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
          
      if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
    }

    return rupiah;
  }

  totalDate(date){
    let total = 0;
    this.listperTanggal.forEach(data => {
        var fullDate = new Date (data.tanggal);
        var dateOnly = String(fullDate.getDate());        
        if (dateOnly == date) {
          total += parseInt(data.total)
        }
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
  }

  totalpercustomer(customer, date){
    let total = 0;
    this.listperTanggalCustomer.forEach(data => {
      if (data.id_customer == customer) {
        var fullDate = new Date (data.tanggal);
        var dateOnly = String(fullDate.getDate());

        if (data.id_customer == customer && dateOnly == date) {
          total += parseInt(data.total)
        }
      }
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
  }

  totalpercust(customer){
    let total = 0;
    this.listperCustomer.forEach(data => {
      if (data.id_customer == customer) {
        total += parseInt(data.total)
      }
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
  }

  donwload(){
    this.penjualanService.download().subscribe((response: Blob) => {
      const fileURL = URL.createObjectURL(response);
      window.open(fileURL);
    });
  }
  
}
