import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class PenjualanCustomerService {

  constructor(private landaService: LandaService, 
    private http: HttpClient) { }

  getpenjualancustomer(arrParameter) {
    return this.landaService.DataGet('/v1/penjualancust',  arrParameter );
}

  getpenjualancustomerById(penjualancustomerId) {
    return this.landaService.DataGet('/v1/penjualancust/' + penjualancustomerId);
}

  download(){
    return this.http.get('/v1/file-export', { responseType: 'blob' });
  }
}
