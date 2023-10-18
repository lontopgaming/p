import { Component, EventEmitter, Input, OnInit, Output, SimpleChange } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';
import { PromoService } from '../../sevices/promo.service';

@Component({
  selector: 'form-promo',
  templateUrl: './form-promo.component.html',
  styleUrls: ['./form-promo.component.scss']
})
export class FormPromoComponent implements OnInit {

    @Input() promoId: number;
    @Output() afterSave  = new EventEmitter<boolean>();
    mode: string;
    formModel : {
        id: number,
        nama: string,
        type: string,
        diskon: number,
        nominal: number,
        kadaluarsa: number,
        foto: string,
        fotoUrl: string,
        syarat_ketentuan: string,
    };
    listTipeDetail: any;


  constructor(
    private promoService: PromoService,
    private landaService: LandaService,
  ) { }

  ngOnInit(): void {
  }
  
  ngOnChanges(changes: SimpleChange) {
    this.emptyForm();
}

  emptyForm() {
    this.mode = 'add';
    this.formModel = {
        id: 0,
        nama: "",
        type: "",
        diskon: 0,
        nominal: 0,
        kadaluarsa:0,
        foto: "",
        fotoUrl: "",
        syarat_ketentuan: "",

    }

    if (this.promoId > 0) {
        this.mode = 'edit';
        this.getPromo(this.promoId);
    }
}

save() {
    if(this.mode == 'add') {
        this.promoService.createPromo(this.formModel).subscribe((res : any) => {
            this.landaService.alertSuccess('Berhasil', res.message);
            this.afterSave.emit();
        }, err => {
            this.landaService.alertError('Mohon Maaf', err.error.errors);
        });
    } else {
        this.promoService.updatePromo(this.formModel).subscribe((res : any) => {
            this.landaService.alertSuccess('Berhasil', res.message);
            this.afterSave.emit();
        }, err => {
            this.landaService.alertError('Mohon Maaf', err.error.errors);
        });
    }
    console.log(this.formModel);
}

getPromo(promoId) {
    this.promoService.getPromoById(promoId).subscribe((res: any) => {
        this.formModel = res.data;
    }, err => {
        console.log(err);
    });
}

trackByIndex(index: number): any {
    return index;
}

back() {
    this.afterSave.emit();
}

getCroppedImage($event) {
    this.formModel.foto = $event;
   }
}
