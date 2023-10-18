import { DatePipe, formatDate } from '@angular/common';
import { Component, OnInit, ViewChild } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { DataTableDirective } from 'angular-datatables';
import { LandaService } from 'src/app/core/services/landa.service';
import Swal from 'sweetalert2';
import { CustomerService } from '../../../customers/services/customer.service';
import { PromoService } from '../../../promo/sevices/promo.service';
import { VoucherService } from '../../service/voucher.service';

@Component({
  selector: 'app-daftar-voucher',
  templateUrl: './daftar-voucher.component.html',
  styleUrls: ['./daftar-voucher.component.scss'],
})
export class DaftarVoucherComponent implements OnInit {

  @ViewChild(DataTableDirective)
  dtElement: DataTableDirective;
  dtInstance: Promise<DataTables.Api>;
  dtOptions: DataTables.Settings = {};
  filter: {
      id_customer: any;
      type : any;
      is_verified: any;
  };

  listCustomer = [];
  listPromo = [];

    modelId: number;
    listVoucher: any =[];
    isOpenForm: boolean = false;
    titleCard: string;

    lista: any;
    tanggal: any;
    periode: any;

  constructor(

    private voucherService: VoucherService,
    private customerService: CustomerService,
    private landaService: LandaService,
    private modalService: NgbModal,
    private promoService: PromoService,
    
  ) {
    
  }

  ngOnInit(): void {
    this.filter ={
      id_customer:'',
      type: '',
      is_verified: '1',
    };
    this.getVoucher();
    this.getCustomer();
    this.getPromo();
  }

  getCustomer(){ 
    const params={
      is_verified: this.filter.is_verified,
    };
    this.customerService.getCustomers(params).subscribe((res: any) => {
    this.listCustomer = res.data.list;
  }, (err: any) => {
    console.log(err);
  });
  }

 showForm(show) {
  this.isOpenForm = show;
}


createVoucher() {
  this.titleCard = 'Tambah ';
  this.modelId = 0;
  this.showForm(true);
  // console.log()
}

updateVoucher (voucherModel) {
  this.titleCard = 'Edit Voucher ';
  this.modelId = voucherModel.id;
  this.showForm(true);
}

deleteVoucher(voucherId) {
  Swal.fire({
      title: 'Apakah kamu yakin ?',
      text: 'Customer tidak memiliki voucher setelah kamu menghapus datanya',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#34c38f',
      cancelButtonColor: '#f46a6a',
      confirmButtonText: 'Ya, Hapus data ini !',
  }).then((result) => {
      if (result.value) {
          this.voucherService.deleteVoucher(voucherId).subscribe((res: any) => {
              this.landaService.alertSuccess('Berhasil', res.message);
              this.getVoucher();
              this.reloadDataTable();
          }, err => {
              console.log(err);
          });
      }
  });
}

reloadDataTable(): void {
  this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
      dtInstance.draw();
  });
}

getVoucher() {
  this.dtOptions = {
    serverSide: true,
    processing: true,
        ordering: false,
        pageLength: 5,
        ajax: (dtParams: any, callback) => {
          const params = {
            id_customer: this.lista ?? '',
            itemperpage: 5,
            per_page: dtParams.length,
            page: (dtParams.start / dtParams.length) + 1,
          };
          
          this.voucherService.getVoucher(params).subscribe((res: any) => {
            this.listVoucher= res.data.list;
     
            callback({
              recordsTotal: res.data.meta.total,
              recordsFiltered: res.data.meta.total,
              data: [],
            });
            
          }, (err: any) => {
     
          });
        },
      };
     }
     
     getPromo(){
    //   const params = {
    //     type: this.filter.type,
    // };
      this.promoService.getPromo([]).subscribe((res: any) => {
      this.listPromo = res.data.list;
    }, (err: any) => {
      console.log(err);
    });
    }

    a(){
    const curr = formatDate(this.listVoucher.tanggal_mulai, 'dd-MM-yyyy' ,this.tanggal);
    return curr;
    console.log(this.listVoucher.tanggal_mulai);
    }

    b(){
      const a = formatDate(this.listVoucher.periode_selesai, 'dd-MM-yyyy' ,this.periode);
      return a;
      console.log(this.listVoucher.periode_selesai);
    }
}





