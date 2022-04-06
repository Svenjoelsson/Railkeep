@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<section class="content-header">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-address-card"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Customers</span>
              <span class="info-box-number">
                <?php 
                $customers = \App\Models\Customers::count();
                echo $customers;
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-warehouse"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Vendors</span>
              <span class="info-box-number">
                <?php 
                $vendors = \App\Models\Vendors::count();
                echo $vendors;
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number">
                <?php 
                $users = \App\Models\User::count();
                echo $users;
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Services</span>
              <span class="info-box-number">
                In progress:
                <?php 
                $services = \App\Models\Services::where('service_status', 'In progress')->count();
                $servicesTotal = \App\Models\Services::count();
                echo $services."/".$servicesTotal;
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          
        </div>
        
      </div>        
      <div class="row mb-2">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-train"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Units</span>
              <span class="info-box-number">
                <?php 
                $units = \App\Models\Units::count();
                echo $units;
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-train"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Utilization</span>
              <span class="info-box-number">
                <?php 
                $unit = \App\Models\Units::all();
                $totalDaysYTD = 0;
                foreach ($unit as $x) {
                  $startTime = new DateTime($x["created_at"]);

                  $endTime = new DateTime(date('Y-m-d'));

                  $y = $endTime->diff($startTime)->format("%a"); //3
                  $totalDaysYTD+= $y;
                }




/*
                $now = time();
                $Year = date("Y")."-01-01";
                $your_date = strtotime($Year);
                $datediff = $now - $your_date;

                $totalDaysYTD = (round($datediff / (60 * 60 * 24))-1) * $units;
*/
                $rent = \App\Models\Rent::all();

                $counter = 0;
                foreach ($rent as $value) {

                    $startTime = new DateTime($value["rentStart"]);

                    if ($value["rentEnd"] !== null) {
                      $endTime = new DateTime($value["rentEnd"]);
                    } else {
                      $endTime = new DateTime(date('Y-m-d'));
                    }
                    $abs_diff = $endTime->diff($startTime)->format("%a"); //3

                    $counter+= $abs_diff;

                    //$diff = $now - $your_date;
                    //echo $value["unit"]." ".round($endTime / (60 * 60 * 24))."<br />";

                }
                //echo round($counter/$totalDaysYTD*100, 2);
                //echo "%";


                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          
        </div>

    </div>

    <script>
      

      
  </script>

    
</section>
@endsection
