import { TestBed } from '@angular/core/testing';

import { PenjualanMenuService } from './penjualan-menu.service';

describe('PenjualanMenuService', () => {
  let service: PenjualanMenuService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PenjualanMenuService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
