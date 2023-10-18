import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
  providedIn: 'root'
})
export class DetailOrderService {

  constructor(private landaService: LandaService) { }

  getdetailorder(arrParameter) {
    return this.landaService.DataGet('/v1/detailorder',  arrParameter );
}

getdetailorderById(detailorderId) {
    return this.landaService.DataGet('/v1/detailorder/' + detailorderId);
}
}
