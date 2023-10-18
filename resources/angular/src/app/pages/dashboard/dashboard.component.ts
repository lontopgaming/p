import { Component, OnInit } from '@angular/core';
import { DashboardService } from './service/dashboard.service';
import { Chart } from 'Chart.js';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
  listTotalToday : any = [];
  listTotalYesterday : any = [];
  listTotalThisMonth : any = [];
  listTotalLastMonth : any = [];

  listNamaBulan: any = [];
  listTotalPerBulan: any = [];


            Awal: any;
            Akhir: any;
          
  chart: any;

  constructor(private dashboardService: DashboardService) { }

  ngOnInit(): void {
        this.getTotalRekap();

        var ctx = document.getElementById('chart');

        this.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [] = [],
                datasets: [{
                    data: [] = [],
                    // backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 0,
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        title: function(tooltipItem, data) {
                            return "Month: " + data['labels'][tooltipItem[0]['index']];
                        },
                        label: function(tooltipItem, data) {
                            return "Revenue: Rp. " + data['datasets'][0]['data'][tooltipItem['index']];
                        },
                    },
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        this.getDataChart();
  }

  getPeriode() {
      if (this.Awal != null && this.Akhir != null) {
          this.removingDataChart();
          this.getDataChart();
      } else {
          this.getDataChart();
      }
  }

  getTotalRekap() {
      this.dashboardService.getTotalRekap([]).subscribe((res: any) => {
          this.listTotalToday = res.totalToday;
          console.log(this.listTotalToday);
          this.listTotalYesterday = res.totalYesterday;
          console.log(this.listTotalYesterday);
          this.listTotalThisMonth = res.totalThisMonth;
          console.log(this.listTotalThisMonth);
          this.listTotalLastMonth = res.totalLastMonth;
          console.log(this.listTotalLastMonth);
      }, err => {
          console.log(err);
      });
  }

  // get total today
  getTotalToday() {
      let totalToday = 0;
      this.listTotalToday.forEach(data => {
          if (data.total != null) {
              totalToday += parseInt(data.total);
          }
      });

      if (totalToday == 0) {
          return 0;
      }

      return this.formatRupiah(totalToday);
  }

  // get total yesterday
  getTotalYesterday() {
      let totalYesterday = 0;
      this.listTotalYesterday.forEach(data => {
          if (data.total != null) {
              totalYesterday += parseInt(data.total)
          }
      });

      if (totalYesterday == 0) {
          return 0;
      }

      return this.formatRupiah(totalYesterday);
  }

  // get total this month (bulan ini)
  getTotalThisMonth() {
      let totalThisMonth = 0;
      this.listTotalThisMonth.forEach(data => {
          if (data.total != null) {
              totalThisMonth = data.total;
          }
      });

      if (totalThisMonth == 0) {
          return 0;
      }

      return this.formatRupiah(totalThisMonth);
  }

  // get total last month (bulan lalu)
  getTotalLastMonth() {
      let totalLastMonth = 0;
      this.listTotalLastMonth.forEach(data => {
          if (data.total != null) {
              totalLastMonth = data.total;
          }
      });

      if (totalLastMonth == 0) {
          return 0;
      }

      return this.formatRupiah(totalLastMonth);
  }

  // format rupiah -> send total
  formatRupiah(nominal) {
      let number = nominal;

      let number_string = String(number),
          sisa = number_string.length % 3,
          rupiah = number_string.substring(0, sisa),
          ribuan = number_string.substring(sisa).match(/\d{3}/g);

      if (ribuan) {
          let separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }

      return 'Rp. ' + rupiah;
  }

  addingDataChart() {
      this.listNamaBulan.forEach((data) => {
          this.chart.data.labels.push(data);
      });

      this.listTotalPerBulan.forEach((dataset) => {
          this.chart.data.datasets[0].data.push(dataset);
      });
      
      this.chart.update();
  }

  removingDataChart() {
      this.listNamaBulan.forEach((data) => {
          this.chart.data.labels.pop();
      });
      
      this.listTotalPerBulan.forEach((dataset) => {
          this.chart.data.datasets[0].data.pop;
      });

      this.chart.update();
  }

  getDataChart() {
      let params = {
          Awal: this.Awal ?? '',
          Akhir: this.Akhir ?? ''
      };

      this.dashboardService.getChart(params).subscribe((res: any) => {
          this.listNamaBulan = res.map((data) => `${data.nama_bulan}` + ' - ' + `${data.tahun}`);
          this.listTotalPerBulan = res.map((data: any) => data.totalPerBulan);

          this.addingDataChart();
      }, err => {
          console.log(err);
      });
  }
}
