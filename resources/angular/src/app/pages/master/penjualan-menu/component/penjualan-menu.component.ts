import { Component, OnInit } from '@angular/core';
import { DetailOrderService } from '../../detail_order/detail-order.service';
import { ItemService } from '../../items/services/item.service';
import { OrderService } from '../../order/order.service';
import { PenjualanMenuService } from '../service/penjualan-menu.service';

@Component({
  selector: 'app-penjualan-menu',
  templateUrl: './penjualan-menu.component.html',
  styleUrls: ['./penjualan-menu.component.scss']
})
export class PenjualanMenuComponent implements OnInit {
  numbers:Array<any> = [];
  listReportTanggalMenu: any = [];
  listReportMenu: any = [];
  listReportTanggal: any = [];
  listReportKategori: any = [];
  listReportTotal: any;
  listFood: any = [];
  listDrink: any = [];
  listSnack: any = [];
  periode: '';
  kategori: any;  

  constructor(
    private penjualanService: PenjualanMenuService,
    private itemService: ItemService
  ) {
    this.numbers = Array.from({length:31},(v,k)=>k+1);
   }

  ngOnInit(): void {
    this.getFood()
    this.getDrink()
    this.getSnack()
    this.getReport('')
  }

  getReport(kategori){
    let params = {
      kategori: kategori ?? '',
      periode: this.periode ?? '',
    };
    if(kategori == 'all'){
      params = {
        kategori: '',
        periode: this.periode ?? '',
      }
    }

    this.penjualanService.getpenjualanmenu(params).subscribe((res: any) => {
        this.listReportTanggalMenu = res.data.list.perTanggalMenu;
        this.listReportMenu = res.data.list.perMenu;
        this.listReportTanggal = res.data.list.perTanggal;
        this.listReportKategori = res.data.list.perKategori;
        this.listReportTotal = res.data.list.total;
        
    }, (err: any) => {
        console.log(err);
    });
  }

  getDrink(){
    const params = {
      kategori: 'drink'
    }
    this.itemService.getItems(params).subscribe((res: any) => {
      this.listDrink = res.data.list;
    }, (err: any) => {
        console.log(err);
    });
  }

  getFood(){
    const params = {
      kategori: 'food'
    }
    this.itemService.getItems(params).subscribe((res: any) => {
      this.listFood = res.data.list;
      console.log(this.listFood)
    }, (err: any) => {
        console.log(err);
    });
  }

  getSnack(){
    const params = {
      kategori: 'snack'
    }
    this.itemService.getItems(params).subscribe((res: any) => {
      this.listSnack = res.data.list;
      console.log(this.listSnack)
    }, (err: any) => {
        console.log(err);
    });
  }

  
  totalMenuDate(menu, date){
    let total = 0;
    this.listReportTanggalMenu.forEach(data => {
      if (data.id_menu == menu) {
        var fullDate = new Date (data.tanggal);
        var dateOnly = String(fullDate.getDate());

        if (data.id_menu == menu && dateOnly == date) {
          total += parseInt(data.total)
        }
      }
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
  }

  totalDate(date){
    let total = 0;
    this.listReportTanggal.forEach(data => {
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

  totalAll(){
    let total = 0;
    this.listReportTotal.forEach(data => {
      total += parseInt(data.total)
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
  }

  totalKategori(kategori){
    let total = 0;
    this.listReportKategori.forEach(data => {
      if (data.kategori == kategori) {
        total += parseInt(data.total)
      }
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
  }

  
  totalMenu(menu){
    let total = 0;
    this.listReportMenu.forEach(data => {
      if (data.id_menu == menu) {
        total += parseInt(data.total)
      }
    });
    if (total == 0) {
      return '-'
    }
    return this.format(total);
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
}
