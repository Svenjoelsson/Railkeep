@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reports</h1>
                    Viewing {{ $model }} {{ $type }} @if ($period) of period {{ $period }} @endif
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
                        <td>{{ $rent->monthlyCost }} kr</td>

                        <td>
                            <?php 
                                $units = \App\Models\Units::where('unit', $rent->unit)->first();
                                $latest = \App\Models\Activities::where('activity_id', $units["id"])->where('activity_type', 'UnitCounter')->whereYear('created_at', '=', now()->format('Y'))->whereMonth('created_at', '=', now()->format('m'))->orderBy('created_at', 'desc')->first();
                                $first = \App\Models\Activities::where('activity_id', $units["id"])->where('activity_type', 'UnitCounter')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('created_at', 'asc')->first();

                                $calc = $latest->activity_message - $first->activity_message;
                                echo $calc;
                            ?>

                        </td>
                        <td>{{ $rent->counterCost }} kr</td>
                        <td>
                            <?php 
                            $subtotal = ($calc * $rent->counterCost) + $rent->monthlyCost;
                            $total += $subtotal;
                                echo $subtotal." kr";
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
                        <td><b><?php echo $total; ?> kr</b></td>
                    </tr>
                </table>
            </div>
    </div>

@endsection

