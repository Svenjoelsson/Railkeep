@extends('layouts.app')

@section('content')

<?php 
function asDollars($value) {
  if ($value<0) return "-".asDollars(-$value);
  return number_format($value, 2);
}
?>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reports</h1>
                    Viewing {{ $model }} {{ $type }} @if ($period) of period <a href="" data-toggle="modal" data-target="#period">{{ $period }}</a> @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">


        <div class="clearfix"></div>

            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th scope="col">Unit</th>
                          <th scope="col">Customer</th>
                          <th scope="col">Monthly cost</th>
                          <th scope="col">Counter total</th>
                          <th scope="col">Counter cost</th>
                          <th scope="col">Sum</th>
                        </tr>
                      </thead>
                <?php 
                $total = 0;
                ?>
                @foreach ($results as $rent)
                    <tr>
                        <td>{{ $rent->unit }}</td>
                        <td>{{ $rent->customer }}</td>
                        <td>{{ asDollars($rent->monthlyCost) }} kr</td>

                        <td>
                            <?php 
                                $units = \App\Models\Units::where('unit', $rent->unit)->first();
                                $latest = \App\Models\Activities::where('activity_id', $units["id"])->where('activity_type', 'UnitCounter')->whereYear('created_at', '=', now()->format('Y'))->whereMonth('created_at', '=', now()->format('m'))->orderBy('created_at', 'desc')->first();
                                $first = \App\Models\Activities::where('activity_id', $units["id"])->where('activity_type', 'UnitCounter')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('created_at', 'asc')->first();

                                $calc = intval($latest->activity_message) - intval($first->activity_message);
                                echo asDollars($calc);
                            ?>

                        </td>
                        <td>{{ $rent->counterCost }} kr</td>
                        <td>
                            <?php 
                            $subtotal = ($calc * intval($rent->counterCost)) + intval($rent->monthlyCost);
                            $total += intval($subtotal);
                                echo asDollars($subtotal)." kr";
                            ?>
                        </td>

                    </tr>
                @endforeach
                    <tr style="background-color:#ccc;">
                        <td><b>Total:</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b><?php echo asDollars($total); ?> kr</b></td>
                    </tr>
                </table>
            </div>
    </div>

    <div class="modal fade" id="period" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change period</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="url" class="form-control" value="<?php echo Request::segment(1)."/".Request::segment(2)."/".Request::segment(3)."/".Request::segment(4); ?>">
                <label>Period (YYYY/MM)</label>
              <input type="text" id="period1" class="form-control" value="<?php echo Request::segment(5)."/".Request::segment(6); ?>">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="updatePeriod" class="btn btn-primary">Change</button>
            </div>
          </div>
        </div>
      </div>

@endsection

