import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
  providedIn: 'root'
})
export class OrderService {

  constructor(private landaService: LandaService) { }

  getorder(arrParameter) {
    return this.landaService.DataGet('/v1/order',  arrParameter );
}

getorderById(orderId) {
    return this.landaService.DataGet('/v1/order/' + orderId);
}
}
