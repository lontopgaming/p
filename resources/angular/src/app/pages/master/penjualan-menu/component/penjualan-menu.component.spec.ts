import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PenjualanMenuComponent } from './penjualan-menu.component';

describe('PenjualanMenuComponent', () => {
  let component: PenjualanMenuComponent;
  let fixture: ComponentFixture<PenjualanMenuComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PenjualanMenuComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PenjualanMenuComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
