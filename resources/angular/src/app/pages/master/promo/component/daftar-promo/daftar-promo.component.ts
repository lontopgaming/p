import { Component, OnInit, ViewChild } from '@angular/core';
import { DataTableDirective } from 'angular-datatables';
import { PromoService } from '../../sevices/promo.service';
import { LandaService } from 'src/app/core/services/landa.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-daftar-promo',
  templateUrl: './daftar-promo.component.html',
  styleUrls: ['./daftar-promo.component.scss']
})
export class DaftarPromoComponent implements OnInit {

    listPromo: [];
    titleCard: string;
    modelId: number;
    isOpenForm: boolean = false;

    @ViewChild(DataTableDirective)
    dtElement: DataTableDirective;
    dtInstance: Promise<DataTables.Api>;
    dtOptions: DataTables.Settings = {};
    filter: {
        name: any;
    };

  constructor(
    private promoService : PromoService,
    private landaService : LandaService
  ) { }

  ngOnInit(): void {
    this.getPromo();
        this.filter = {
            name:''
        }
  }

  reloadDataTable(): void {
    this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
        dtInstance.draw();
    });
}

  trackByIndex(index: number): any {
    return index;
    }

    getPromo() {
      this.dtOptions = {
          serverSide: true,
          processing: true,
          ordering: false,
          pageLength: 5,
          ajax: (dtParams: any, callback) => {
            const params = {
              nama: this.filter.name,
              itemperpage: 5,
              per_page: dtParams.length,
              page: (dtParams.start / dtParams.length) + 1,
            }; 
       
            this.promoService.getPromo(params).subscribe((res: any) => {
              this.listPromo = res.data.list;
       
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

       showForm(show) {
        this.isOpenForm = show;
    }

    createPromo() {
      this.titleCard = 'Tambah Promo';
      this.modelId = 0;
      this.showForm(true);
  }

  updatePromo(promoModel) {
    this.titleCard = 'Edit Promo: ' + promoModel.nama;
    this.modelId = promoModel.id;
    this.showForm(true);
}

deletePromo(promoId) {
    Swal.fire({
        title: 'Apakah kamu yakin ?',
        text: 'anda tidak dapat melakukan promo setelah kamu menghapus datanya',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#34c38f',
        cancelButtonColor: '#f46a6a',
        confirmButtonText: 'Ya, Hapus data ini !',
    }).then((result) => {
        if (result.value) {
            this.promoService.deletePromo(promoId).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.getPromo();
                this.reloadDataTable();
            }, err => {
                console.log(err);
            });
        }
    });
}

}
