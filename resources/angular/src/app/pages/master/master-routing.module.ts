import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DaftarCustomerComponent } from './customers/components/daftar-customer/daftar-customer.component';
import { DaftarDiskonComponent } from './diskon/component/daftar-diskon.component';
import { DaftarItemComponent } from './items/components/daftar-item/daftar-item.component';
import { PenjualanCustomerComponent } from './penjualan-customer/component/penjualan-customer.component';
import { PenjualanMenuComponent } from './penjualan-menu/component/penjualan-menu.component';
import { ProfileComponent } from './profile/profile.component';
import { DaftarPromoComponent } from './promo/component/daftar-promo/daftar-promo.component';
import { RekapPenjualanComponent } from './rekap-penjualan/component/rekap-penjualan.component';
import { DaftarRolesComponent } from './roles/components/daftar-roles/daftar-roles.component';
import { DaftarUserComponent } from './users/components/daftar-user/daftar-user.component';
import { DaftarVoucherComponent } from './voucher/component/daftar-voucher/daftar-voucher.component';


const routes: Routes = [
    { path: 'users', component: DaftarUserComponent },
    { path: 'roles', component: DaftarRolesComponent },
    { path: 'customers', component: DaftarCustomerComponent },
    { path: 'items', component: DaftarItemComponent },
    { path: 'profile', component: ProfileComponent},
    { path: 'promo', component: DaftarPromoComponent},
    { path: 'diskon', component: DaftarDiskonComponent},
    { path: 'voucher', component: DaftarVoucherComponent},
    { path: 'penjualan menu', component: PenjualanMenuComponent},
    { path: 'penjualan customer', component: PenjualanCustomerComponent},
    { path: 'rekap penjualan', component: RekapPenjualanComponent},
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class MasterRoutingModule { }
