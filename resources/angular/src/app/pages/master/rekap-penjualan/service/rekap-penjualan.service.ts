import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
  providedIn: 'root'
})
export class RekapPenjualanService {

  constructor(private landaService: LandaService) { }

  getrekappenjualan(arrParameter) {
    return this.landaService.DataGet('/v1/rekap',  arrParameter );
}

  getrekappenjualanById(rekapId) {
    return this.landaService.DataGet('/v1/rekap/' + rekapId);
}
}
