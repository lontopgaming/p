import { TestBed } from '@angular/core/testing';

import { DetailOrderService } from './detail-order.service';

describe('DetailOrderService', () => {
  let service: DetailOrderService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(DetailOrderService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
