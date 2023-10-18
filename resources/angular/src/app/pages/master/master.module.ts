import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import {
    NgbModule,
    NgbTooltipModule,
    NgbModalModule,
    NgbPagination
} from '@ng-bootstrap/ng-bootstrap';
import { NgSelectModule } from '@ng-select/ng-select';
import { DataTablesModule } from 'angular-datatables';

import { MasterRoutingModule } from './master-routing.module';
import { DaftarUserComponent } from './users/components/daftar-user/daftar-user.component';
import { FormUserComponent } from './users/components/form-user/form-user.component';
import { DaftarRolesComponent } from './roles/components/daftar-roles/daftar-roles.component';
import { FormRolesComponent } from './roles/components/form-roles/form-roles.component';
import { DaftarCustomerComponent } from './customers/components/daftar-customer/daftar-customer.component';
import { FormCustomerComponent } from './customers/components/form-customer/form-customer.component';
import { FormItemComponent } from './items/components/form-item/form-item.component';
import { DaftarItemComponent } from './items/components/daftar-item/daftar-item.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { ProfileComponent } from './profile/profile.component';
import { DaftarPromoComponent } from './promo/component/daftar-promo/daftar-promo.component';
import { FormPromoComponent } from './promo/component/form-promo/form-promo.component';
import { DaftarDiskonComponent } from './diskon/component/daftar-diskon.component';
import { BrowserModule } from '@angular/platform-browser';
import { DaftarVoucherComponent } from './voucher/component/daftar-voucher/daftar-voucher.component';
import { FormVoucherComponent } from './voucher/component/form-voucher/form-voucher.component';
import { RekapPenjualanComponent } from './rekap-penjualan/component/rekap-penjualan.component';
import { PenjualanCustomerComponent } from './penjualan-customer/component/penjualan-customer.component';
import { PenjualanMenuComponent } from './penjualan-menu/component/penjualan-menu.component';




@NgModule({
    declarations: [DaftarUserComponent, FormUserComponent, DaftarRolesComponent, FormRolesComponent, DaftarCustomerComponent, FormCustomerComponent, FormItemComponent, DaftarItemComponent, ProfileComponent, DaftarPromoComponent, FormPromoComponent, DaftarDiskonComponent, DaftarVoucherComponent, FormVoucherComponent, RekapPenjualanComponent, PenjualanCustomerComponent, PenjualanMenuComponent], 
    imports: [
        CommonModule,
        MasterRoutingModule,
        NgbModule,
        NgbTooltipModule,
        NgbModalModule,
        NgSelectModule,
        FormsModule,
        DataTablesModule,
        SharedModule,
        
        
    ]
})
export class MasterModule { }
