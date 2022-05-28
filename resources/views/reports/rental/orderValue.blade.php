@extends('layouts.app')

@section('content')

<?php 
function asSEK($value, $currency) {
  if (str_contains($value, ' ')) {
    $value = str_replace(" ", "", $value);
  }
  $fmt = numfmt_create( 'se-SE', NumberFormatter::CURRENCY );
  return numfmt_format_currency($fmt, $value, $currency);
}
?>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reports</h1>
                    Total order value
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
                          <th scope="col">Rent start</th>
                          <th scope="col">Rent End</th>
                          <th scope="col">Months</th>
                          <th scope="col">Sub total</th>
                        </tr>
                      </thead>
                <?php 
                $total = 0;
                ?>
                @foreach ($results as $rent)
                <?php 
                ?>
                    <tr>
                        <td>{{ $rent->unit }}</td>
                        <td>{{ $rent->customer }}</td>
                        <td>{{ asSEK($rent->monthlyCost, $rent->currency) }}</td>
                        <td>{{ $rent->rentStart }}</td>
                        <td><?php 
                        if ($rent->rentEnd) {
                          echo $rent->rentEnd;
                        } else {
                          echo "<span data-toggle='tooltip' title='No end date is set, calculating on todays date.' style='color:red;'>".date('Y-m-d')."</span>";
                          $rent->rentEnd = date('Y-m-d');
                        }
                        ?></td>
                        <td><?php 
                        if ($rent->rentEnd) {
                          $date1 = new DateTime($rent->rentStart);
                          $date2 = new DateTime($rent->rentEnd);

                          $interval = $date2->diff($date1);

                          $months = ($interval->y * 12) + $interval->m;
                          $months += number_format($interval->d / 30, 1);
                          echo $months;

                        }
                        ?></td>
                        <td><?php 
                        if ($rent->rentEnd) {

                          $value = $rent->monthlyCost;

                          $date1 = new DateTime($rent->rentStart);
                          $date2 = new DateTime($rent->rentEnd);

                          $interval = $date2->diff($date1);

                          $months = ($interval->y * 12) + $interval->m;
                          $months += number_format($interval->d / 30, 1);
                          $totalVal = $months * $value;
                          
                          if ($rent->currency !== 'SEK') {
                            $totalVal = Currency::convert()
                              ->from($rent->currency)
                              ->to('SEK')
                              ->amount($totalVal)
                              ->get();
                          }
                          $total += $totalVal;
                          echo asSEK($totalVal, 'SEK');
                        }

                        ?></td>
                    </tr>
                @endforeach
                    <tr style="background-color:#ccc;">
                        <td><b>Total:</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b><?php echo asSEK($total, $rent->currency); ?></b></td>
                    </tr>
                </table>
            </div>
    </div>


@endsection

