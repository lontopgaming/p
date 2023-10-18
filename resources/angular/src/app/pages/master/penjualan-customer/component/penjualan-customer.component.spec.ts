import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PenjualanCustomerComponent } from './penjualan-customer.component';

describe('PenjualanCustomerComponent', () => {
  let component: PenjualanCustomerComponent;
  let fixture: ComponentFixture<PenjualanCustomerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PenjualanCustomerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PenjualanCustomerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
