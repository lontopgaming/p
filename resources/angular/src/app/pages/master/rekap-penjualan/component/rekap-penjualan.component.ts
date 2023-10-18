import { Component, OnInit } from '@angular/core';
import { CustomerService } from '../../customers/services/customer.service';
import { ItemService } from '../../items/services/item.service';
import { OrderService } from '../../order/order.service';
import { PromoService } from '../../promo/sevices/promo.service';
import { RekapPenjualanService } from '../service/rekap-penjualan.service';

@Component({
  selector: 'app-rekap-penjualan',
  templateUrl: './rekap-penjualan.component.html',
  styleUrls: ['./rekap-penjualan.component.scss']
})
export class RekapPenjualanComponent implements OnInit {
  listitem: any;
  listCustomer: any;
  tanggal: "";
  listpenjualan: any = [];
  listpromo: any;
  menu: "";
  customer: any;
  periode: any;
  nama: any;

  constructor(
    private orderService: OrderService,
    private customerService: CustomerService,
    private itemService: ItemService,
    private rekapService: RekapPenjualanService,
    private promoService: PromoService
  ) { }

  ngOnInit(): void {
    this.getReport('')
    this.getCustomer()
    this.getItem()
    this.getPromo()
  }

  getItem(){
    const params = {
      menu: ''
    }
    this.itemService.getItems(params).subscribe((res: any) => {
      this.listitem = res.data.list;
      // console.log(this.listitem)
    }, (err: any) => {
      console.log(err);
    })
  }

  getCustomer(){
    const params = {
      customer: ''
    }
    this.customerService.getCustomers(params).subscribe((res: any) => {
      this.listCustomer = res.data.list;
      // console.log(this.listCustomer)
    }, (err: any) => {
      console.log(err);
    })
  }

  getPromo(){
        // const params = {
    //   customer: ''
    // }
    this.promoService.getPromo([]).subscribe((res: any) => {
      this.listpromo = res.data.list;
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

  getReport(customer){
    let params = {
      customer: customer ?? '',
      tanggal: this.tanggal ?? '',
      menu: this.menu ?? ''
    };
    if(customer == 'all'){
      params = {
        customer: '',
        tanggal: this.tanggal ?? '',
        menu: this.menu ?? ''
      }
    }

    this.rekapService.getrekappenjualan(params).subscribe((res: any) => {
         this.listpenjualan = res.data.list;
        // this.listReportCustomer = res.data.list.perCustomer;
        // this.listperTanggal = res.data.list.perTanggal;
        // this.listperCustomer = res.data.list.perCustomer;
        // this.listReportTotal = res.data.list.total;
        // console.log(this.listpenjualan)
    }, (err: any) => {
        console.log(err);
    });
  }


}
