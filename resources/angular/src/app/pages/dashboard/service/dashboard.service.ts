import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  constructor(private landaService: LandaService) {}

  getTotalRekap(arrParameter){
    return this.landaService.DataGet('/v1/home',  arrParameter );
  }
  getChart(arrParameter){
    return this.landaService.DataGet('/v1/chart',  arrParameter );
  }
}

