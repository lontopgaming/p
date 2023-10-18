import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LandaService } from 'src/app/core/services/landa.service';
import { AuthService } from '../../auth/services/auth.service';
import { RoleService } from '../roles/services/role-service.service';
import { UserService } from '../users/services/user-service.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit {
  UserLogin;
  titleModal: string;
  @Input() userId: number;
  @Output() afterSave  = new EventEmitter<boolean>();
  mode: string;
  listAkses: [];
  formModel : {
      id: number,
      nama: string,
      akses: {
          id: number,
          nama: string
      },
      foto: string,
      fotoUrl: string,
      email: string,
      password: string
    }
  
  modelId: number;
  
  constructor(private userService: UserService,
    private roleService: RoleService,
    private AuthService: AuthService, 
    private landaService: LandaService,
    private modalService: NgbModal) {}

  ngOnInit(): void {
    
    this.formModel;

    this.AuthService.getProfile().subscribe((user: any) => {
      this.UserLogin = user;
  });
  }


  emptyForm() {
    this.mode = 'add';
    this.formModel = {
        id: 0,
        nama: '',
        akses: {
            id: 0,
            nama: ''
        },
        foto: '',
        fotoUrl: '',
        email: '',
        password: ''
    }

    if (this.userId > 0) {
        this.mode = 'edit';
        this.getUser(this.userId);
    }
}


save() {
  if(this.mode == 'add') {
      this.userService.createUser(this.formModel).subscribe((res : any) => {
          this.landaService.alertSuccess('Berhasil', res.message);
          this.afterSave.emit();
      }, err => {
          this.landaService.alertError('Mohon Maaf', err.error.errors);
      });
  } else {
      this.userService.updateUser(this.formModel).subscribe((res : any) => {
          this.landaService.alertSuccess('Berhasil', res.message);
          this.afterSave.emit();
      }, err => {
          this.landaService.alertError('Mohon Maaf', err.error.errors);
      });
  }
}

getRole() {
  this.roleService.getRoles([]).subscribe((res: any) => {
      this.listAkses = res.data.list;
  }, err => {
      console.log(err);
  })
}

getUser(userId) {
  this.userService.getUserById(userId).subscribe((res: any) => {
      this.formModel = res.data;
  }, err => {
      console.log(err);
  });
}

getCroppedImage($event) {
  this.formModel.foto = $event;
 }

 updateUser(modal, userModel) {
  this.titleModal = 'Edit User: ' + userModel.nama;
  this.modelId = userModel.id;
  this.modalService.open(modal, { size: 'lg', backdrop: 'static' });
}
 

}