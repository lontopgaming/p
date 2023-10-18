import { Component, OnInit, ViewChild } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import Swal from 'sweetalert2';

import { LandaService } from 'src/app/core/services/landa.service';
import { ItemService } from '../../services/item.service';
import { DataTableDirective } from 'angular-datatables';

@Component({
    selector: 'item-daftar',
    templateUrl: './daftar-item.component.html',
    styleUrls: ['./daftar-item.component.scss']
})
export class DaftarItemComponent implements OnInit {

    listItems: [];
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
        private itemService: ItemService,
        private landaService: LandaService,
        private modalService: NgbModal
    ) { }

    ngOnInit(): void {
        this.getItem();
        this.filter = {
            name:''
        }
    }

    trackByIndex(index: number): any {
        return index;
    }

    getItem() {
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
         
              this.itemService.getItems(params).subscribe((res: any) => {
                this.listItems = res.data.list;
         
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

    createItem() {
        this.titleCard = 'Tambah Item';
        this.modelId = 0;
        this.showForm(true);
    }

    updateItem(itemModel) {
        this.titleCard = 'Edit Item: ' + itemModel.nama;
        this.modelId = itemModel.id;
        this.showForm(true);
    }

    deleteItem(userId) {
        Swal.fire({
            title: 'Apakah kamu yakin ?',
            text: 'Item tidak dapat melakukan pesanan setelah kamu menghapus datanya',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34c38f',
            cancelButtonColor: '#f46a6a',
            confirmButtonText: 'Ya, Hapus data ini !',
        }).then((result) => {
            if (result.value) {
                this.itemService.deleteItem(userId).subscribe((res: any) => {
                    this.landaService.alertSuccess('Berhasil', res.message);
                    this.getItem();
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

}
