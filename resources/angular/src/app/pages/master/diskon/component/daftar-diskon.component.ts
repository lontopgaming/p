  import { ChangeDetectorRef, Component, EventEmitter, Input, NgModule, OnInit, Output, ViewChild } from '@angular/core';
  import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
  import { DataTableDirective } from 'angular-datatables';
  import { LandaService } from 'src/app/core/services/landa.service';
  import Swal from 'sweetalert2';
 
import { DiskonService } from '../services/diskon.service';
import { CustomerService } from '../../customers/services/customer.service';
import { PromoService } from '../../promo/sevices/promo.service';
import { NgbPagination } from '@ng-bootstrap/ng-bootstrap';
import { data } from 'jquery';

  @Component({
    selector: 'app-daftar-diskon',
    templateUrl: './daftar-diskon.component.html',
    styleUrls: ['./daftar-diskon.component.scss']
  })
  export class DaftarDiskonComponent implements OnInit {
  
    Page = 1;
    pagesize = 5;
    number : Array<any> = [];

    listCustomer: any =[];
    listPromo = [];
    filter: {
        name: any;
        type: any;
        nama: any;
    };

    listDiskon: any = [];
    titleModal: string;
    modelId: number;

    formModel:{
      id: number,
      id_customer: number,
      id_promo: number,
      status: number,
    }
    diskonMethod: string;
    @Input() diskonId: number;
    @Output() afterSave  = new EventEmitter<boolean>();
    mode: string;
    check: any;
    search: any


    constructor(
      private diskonService:DiskonService,
      private customerService:CustomerService,
      private promoService:PromoService,
      private landaService:LandaService,
      private modalService:NgbModal,
    ) {}

    


    ngOnInit(): void {
      this.filter = {
        name:'',
        type:'diskon',
        nama: ''
      };
      this.getCustomer()
      this.getPromo()
      this.getdiskon()
    }


    
    getCustomer(){ 
      const params ={
        nama: this.search ?? '',
      }
      this.customerService.getCustomers(params,).subscribe((res: any) => {
        // Console.log(this.listCustomer)
        this.listCustomer = res.data.list;
  }, (err: any) => {
    console.log(err);
  });   
  }


  onPageChange(page: number) {
    this.Page = page;
    // this.getCustomer();
  }

  getPromo(){
    const params = {
      type: this.filter.type,
  };
    this.promoService.getPromo(params).subscribe((res: any) => {
    this.listPromo = res.data.list;
  }, (err: any) => {
    console.log(err);
  });
  }

  creatediskon(customer, promo) {
    this.formModel={
      id: 0,
      id_customer: customer,
      id_promo: promo,
      status: 1,
    }
    this.diskonService.creatediskon(this.formModel).subscribe((res: any) => {
      this.landaService.alertSuccess('Berhasil', res.message);
    }, err => {
      this.landaService.alertError('Mohon Maaf', err.error.errors);
    })
  }

  updatediskon(customer, promo) {
    this.formModel={
      id: 0,
      id_customer: customer,
      id_promo: promo,
      status: 1,
    }
    this.diskonService.updatediskon(this.formModel).subscribe((res: any) =>{
      this.landaService.alertSuccess('Berhasil', res.message);
    }, err => {
      this.landaService.alertError('Mohon Maaf', err.error.errors);
    })
  }

  checkdiskon(){
    if (this.diskonMethod == '0') {
      console.log('post'); 
    } 
    else{
      console.log('edit');
    }
  }

  getdiskon(){

    this.diskonService.getdiskon([]).subscribe((res: any) => {
    this.listDiskon = res.data.list;
  }, (err: any) => {
    console.log(err);
  });
  }

  checkid(customer, promo, )
  {
      const params = {
        id_customer: customer,
        id_promo: promo,
      };

      if (this.listDiskon.find(u => u.id_customer === params.id_customer && u.id_promo === params.id_promo)) {
        var aa = this.listDiskon.find(u => u.id_customer === params.id_customer && u.id_promo === params.id_promo);
        const form = {
          id: aa.id,
          id_customer: customer,
          id_promo: promo,
          status: aa.status == 1  ? '0' : '1'
        }
          this.updatediskon(customer, promo);  
      } else {
        this.creatediskon(customer, promo);
      }

    
      this.getCustomer();
      this.getPromo();
      this.getdiskon();
    }



  getstatus(id_customer, id_promo){
    const params={
      id_customer: id_customer,
      id_promo: id_promo,
      status: 1
    }

    if(this.listDiskon.find(u=>u.id_customer === params.id_customer && u.id_promo === params.id_promo)){
    var status = this.listDiskon.find(u=>u.id_customer === params.id_customer && u.id_promo === params.id_promo).status;
      if(status == 1){
        return 'fa-check-square';
      }else{
        return 'fa-minus';
      }
    }
    else{
      return 'fa-minus';
    }
  }

  gettotalpages(): number {
    const pageCount = Math.ceil(this.listCustomer.length / this.pagesize);
    return pageCount > 0 ? pageCount : 1;
  }
  

  getcustomerpage() {

    const start = (this.Page -1) * this.pagesize;
    const end = start + this.pagesize;
    
    return this.listCustomer.slice(start, end);
    
  }

  // getStatusClass(id_customer: number, id_promo: number) {
  //   const diskon = this.listDiskon.find(d => d.id_customer === id_customer && d.id_promo === id_promo);
  
  //   if (diskon && diskon.status === 1) {
  //     return 'fa fa-check-square';
  //   } else {
  //     return 'fa fa-minus';
  //   }
  // }
  



}
  


