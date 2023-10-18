import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
    providedIn: 'root'
})
export class DiskonService {

    constructor(private landaService: LandaService) { }

    getdiskon(arrParameter) {
        return this.landaService.DataGet('/v1/diskon',  arrParameter );
    }

    getdiskonById(diskonId) {
        return this.landaService.DataGet('/v1/diskon/' + diskonId);
    }

    creatediskon(payload) {
        return this.landaService.DataPost('/v1/diskon', payload);
    }

    updatediskon(payload) {
        return this.landaService.DataPut('/v1/diskon', payload);
    }

    deletediskon(diskonId) {
        return this.landaService.DataDelete('/v1/diskon/' + diskonId);
    }

    getdiskonall(arrParameter) {
        return this.landaService.DataGet('/v1/get-diskon-all');
    }
}
