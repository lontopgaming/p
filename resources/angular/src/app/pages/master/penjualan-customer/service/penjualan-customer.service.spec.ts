import { TestBed } from '@angular/core/testing';

import { PenjualanCustomerService } from './penjualan-customer.service';

describe('PenjualanCustomerService', () => {
  let service: PenjualanCustomerService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PenjualanCustomerService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
