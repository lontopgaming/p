import { Component, EventEmitter, Input, OnInit, Output, SimpleChange } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

import { CustomerService } from '../../../customers/services/customer.service';
import { PromoService } from '../../../promo/sevices/promo.service';
import { VoucherService } from '../../service/voucher.service';

@Component({
  selector: 'voucher-form',
  templateUrl: './form-voucher.component.html',
  styleUrls: ['./form-voucher.component.scss']
})
export class FormVoucherComponent implements OnInit {

  @Input() voucherId: number;
  @Output() afterSave  = new EventEmitter<boolean>();
  mode: string;
  listCustomer : any = [];
  listPromo : [];
  formModel : {
      id: number,
      id_customer: {
        nama : string,
        id : number,
      },
      id_promo: {
        id : number,
        nama : string,
        nominal: number,
        nominalUpdate:number,
        kadaluarsa:number,
      },
      jumlah: number,
      jumlah_nominal: number,
      tanggal_mulai: string,
      periode_selesai: string,
      catatan: string,


  };
  listTipeDetail: any;
    nominal: number;
    jumlah: number;
    
  

  constructor(
      private voucherService: VoucherService,
      private promoService : PromoService,
      private customerService : CustomerService,
      private landaService: LandaService
  ) {}

  ngOnInit(): void {
    this.getPromo();
    this.getCustomer();
      
  }
  
  ngOnChanges(changes: SimpleChange) {
      this.emptyForm();
  }

  emptyForm() {
      this.mode = 'add';
      this.formModel = {
          id: 0,
          id_customer: {
            id : 0,
            nama : '',
          },
          id_promo: {
            id : 0,
            nama : '',
            nominal: 0,
            nominalUpdate:0,
            kadaluarsa:0,
          },
          jumlah: 0,
          jumlah_nominal: 0,
          tanggal_mulai: new Date().toISOString().substring(0, 10),// 2023-03-08T02:52:01.721Z
          periode_selesai: '',
          catatan: '',
      }


      if (this.voucherId > 0) {
          this.mode = 'edit';
          this.getVoucher(this.voucherId);
      }
  }

  save() {
      if(this.mode == 'add') {
          this.voucherService.createVoucher(this.formModel).subscribe((res : any) => {
              this.landaService.alertSuccess('Berhasil', res.message);
              this.afterSave.emit();
          }, err => {
              this.landaService.alertError('Mohon Maaf', err.error.errors);
          });
      } else {
          this.voucherService.updateVoucher(this.formModel).subscribe((res : any) => {
              this.landaService.alertSuccess('Berhasil', res.message);
              this.afterSave.emit();
          }, err => {
              this.landaService.alertError('Mohon Maaf', err.error.errors);
          });
      }
  }

  getVoucher(voucherId) {
      this.voucherService.getVoucherById(voucherId).subscribe((res: any) => {
          this.formModel = res.data;
          this.nominal = res.data.id_promo.nominalUpdate;
      }, err => {
          console.log(err);
      });
  }
  getVoucherById(voucherId) {
    this.promoService.getPromoById(voucherId).subscribe((res: any) => {
        this.formModel.id_promo.id = res.data.id;
        this.formModel.id_promo.nama = res.data.nama;
        this.formModel.id_promo.nominal = res.data.nominal;
        this.formModel.id_promo.kadaluarsa = res.data.kadaluarsa;
        this.nominal = res.data.nominal;
        this.formModel.jumlah_nominal = res.data.nominal;

        // hitung tanggal selesai
        const periodeMulai = new Date(this.formModel.tanggal_mulai).getTime();
        const periodeSelesai = new Date(periodeMulai + (this.formModel.id_promo.kadaluarsa * 86400000));
        this.formModel.periode_selesai = periodeSelesai.toISOString().substring(0, 10);

        // set awal
        this.formModel.jumlah = 0;
        this.formModel.tanggal_mulai = new Date().toISOString().substring(0, 10);

    }, err => {
        console.log(err);
    });
}
setNominal(event: any) {
    this.formModel.jumlah = event.target.value;
    console.log(this.formModel.jumlah);
    this.jumlah = (this.formModel.jumlah * this.nominal);
    
    if(this.formModel.jumlah == 0) {
        this.formModel.jumlah_nominal = this.nominal;
    } else {
        this.formModel.jumlah_nominal = this.jumlah;
    }
}


  getPromo(){
    const params = {
        type: 'voucher'
    };
    this.promoService.getPromo(params).subscribe((res:any) => {
        this.listPromo = res.data.list;
    }, err=>{
        console.log(err);
    }) 
  }

  getCustomer(){
    const params = {
        is_verified: '1'
    };
    this.customerService.getCustomers(params).subscribe((res:any) => {
        this.listCustomer = res.data.list;
    }, err=>{
        console.log(err);
    }) 
  }

  setChangePeriodeMulai(event:any){
    const newPeriodeMulai = event.target.value;
    const periodeMulai = new Date(newPeriodeMulai).getTime();
    const periodeSelesai = new Date (periodeMulai + (this.formModel.id_promo.kadaluarsa * 86400000));
    this.formModel.periode_selesai = periodeSelesai.toISOString().substring(0, 10);
  }


  trackByIndex(index: number): any {
      return index;
  }

  back() {
      this.afterSave.emit();
  }

}