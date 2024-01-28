<div>
    <x-slot name="title">
       Admin Dashboard
    </x-slot>
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 m-0 font-weight-bold text-primary">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row justify-content-center">

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4 text-center">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Documents</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><span>{{ $totalDocument }}</span></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-file fa-2x text-gray-500"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4 text-center">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Users</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><span>{{$totalUser}}</span></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-500"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pending Requests Card Example -->
          <div class="col-xl-3 col-md-6 mb-4 text-center">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">For Disposal</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><span>{{$totalRecycles}}</span></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-recycle fa-2x text-gray-500"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 mb-4 d-flex flex-column" style="margin-left: 100px; margin-right: 100px;">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Document Types</h6>
                <!-- Add your dropdown if needed -->
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                  <canvas id="userPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-circle text-primary"></i> Permanent: {{ $totalDoctype }}
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle text-success"></i> Temporary: {{ $totalDoctype1 }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-7 mb-4"> <!-- Adjusted width classes -->
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">File Types</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div class="chart-bar pt-4 pb-2">
                  <canvas id="recordBarChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Administrative: {{ $totalAdministrative }}
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Financial: {{ $totalFinancial }}
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-square text-info"></i> Legal: {{ $totalLegalRecords }}
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-square text-warning"></i> Personnel: {{ $totalPersonnelRecords }}
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-square text-danger"></i> Social Services: {{ $totalSocialServices }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script src="{{asset('admin_assets/js/chart.js')}}"></script>
        <script>
          document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('userPieChart').getContext('2d');
            var myPieChart = new Chart(ctx, {
              type: 'pie',
              data: {
                labels: ['Permanent', 'Temporary'],
                datasets: [{
                  data: [{{ $totalDoctype }}, {{ $totalDoctype1 }}],
                  backgroundColor: ['#4e73df', '#1cc88a'],
                  hoverBackgroundColor: ['#2e59d9', '#17a673'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: true,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false,
                },
                cutoutPercentage: 80,
              },
            });
            var ctxBar = document.getElementById('recordBarChart').getContext('2d');
            var myBarChart = new Chart(ctxBar, {
              type: 'bar',
              data: {
                labels: ['Administrative', 'Financial', 'Legal', 'Personnel', 'Social Services'],
                datasets: [{
                  label: 'Number of Records',
                  data: [
                    {{ $totalAdministrative }},
                    {{ $totalFinancial }},
                    {{ $totalLegalRecords }},
                    {{ $totalPersonnelRecords }},
                    {{ $totalSocialServices }}
                  ],
                  backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                  hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#d63031'],
                  borderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: false,
                scales: {
                  x: {
                    grid: {
                      display: false
                    },
                    ticks: {
                      display: false // Hide the side numbers (ticks)
                    }
                  },
                  y: {
                    grid: {
                      drawBorder: false,
                      color: function (context) {
                        if (context.tick.value < 0) {
                          return '#f00';
                        }
                        return '#ddd';
                      }
                    },
                    ticks: {
                      display: false, // Hide the y-axis numbers (ticks)
                    }
                  }
                },
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false,
                },
              },
            });
          });
        </script>
    </div>
</div>
