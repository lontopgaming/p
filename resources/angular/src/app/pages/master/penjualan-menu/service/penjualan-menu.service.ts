import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
  providedIn: 'root'
})
export class PenjualanMenuService {

  constructor(private landaService: LandaService) { }

  getpenjualanmenu(arrParameter) {
    return this.landaService.DataGet('/v1/penjualanmenu',  arrParameter );
}

  getpenjualanmenuById(penjualanmenuId) {
    return this.landaService.DataGet('/v1/penjualanmenu/' + penjualanmenuId);
}
}
