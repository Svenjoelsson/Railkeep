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
    <div class="container-fluid shadow-lg card card-body">
        <h4>Unit status</h4>
        <div class="row well">


            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-success">
                    <span class="info-box-icon"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Fully operational</span>
                        <span class="info-box-number">{{ $operatingUnits}} ({{$perc}}%)</span>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-blue" data-toggle="modal" data-target="#planned">
                    <span class="info-box-icon"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Planned</span>
                        <span class="info-box-number">{{ $planned }}</span>
                    </div>

                </div>

            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-warning" data-toggle="modal" data-target="#soon">
                    <span class="info-box-icon"><i style="color:white !important;" class="fa fa-exclamation"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:white !important;">Over
                            {{ $soondue }}% reached</span>
                        <span class="info-box-number" style="color:white !important;">{{ $ninty }}</span>
                    </div>
                </div>
            </div>



            <div class="col-md-2 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-danger" data-toggle="modal" data-target="#overdue">
                    <span class="info-box-icon"><i class="fas fa-ban"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Overdue</span>
                        <span class="info-box-number">{{ $overdue }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-danger" data-toggle="modal" data-target="#critical">
                    <span class="info-box-icon"><i class="fas fa-ban"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Critical</span>
                        <span class="info-box-number">{{ $critical }}</span>
                    </div>
                </div>
            </div>

            <h4>Statistics</h4>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-lg bg-gradient-white">
                        <div class="info-box-content">
                            <span class="info-box-text">Kilometers driven last 24h:</span>
                            <span class="info-box-number">{{ $totalKm }} km</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-lg bg-gradient-white">
                        <div class="info-box-content">
                            <span class="info-box-text">Hours driven last 24h:</span>
                            <span class="info-box-number">{{ $totalH }} h</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-lg bg-gradient-white">
                        <div class="info-box-content">
                            <span class="info-box-text">Total amount of units:</span>
                            <span class="info-box-number">{{ $units }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<div class="modal fade" id="critical" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Critical</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="row">

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Unit</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    $critical = \App\Models\Services::where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->get();

                    if ($critical) {
                        foreach ($critical as $x) {
                            $unit = \App\Models\Units::where('unit', $x->unit)->whereNull('deleted_at')->first();

                            echo "<tr>";
                            echo "<td>".$x->unit."</td>";
                            echo "<td><a href='/units/".$unit->id."'>View</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                            </tbody>

                        </table>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-white" style="float:right;" data-dismiss="modal" aria-label="Close"
                            data-toggle="close">Close</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="overdue" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Overdue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="row">

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Unit</td>
                                    <td>Counter / Date</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    $overdue = \App\Models\Activities::where('activity_type', 'like', 'Overdue-%')->whereNull('deleted_at')->get();

                    if ($overdue) {
                        foreach ($overdue as $y) {
                            $unit = \App\Models\Units::where('id', $y->activity_id)->whereNull('deleted_at')->first();

                            echo "<tr>";
                            echo "<td>".$unit->unit."</td>";
                            echo "<td>".$y->activity_message."</td>";
                            echo "<td><a href='/units/".$unit->id."'>View</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                            </tbody>

                        </table>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-white" style="float:right;" data-dismiss="modal" aria-label="Close"
                            data-toggle="close">Close</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="soon" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Soon overdue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="row">

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Unit</td>
                                    <td>Counter</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    $soon = \App\Models\Activities::where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-%')->whereNull('deleted_at')->orderBy('id','desc')->get();

                    if ($soon) {
                        foreach ($soon as $y) {
                            $unit = \App\Models\Units::where('id', $y->activity_id)->whereNull('deleted_at')->first();

                            echo "<tr>";
                            echo "<td>".$unit->unit."</td>";
                            echo "<td>".$y->activity_message."</td>";
                            echo "<td><a href='/units/".$unit->id."'>View</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                            </tbody>

                        </table>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-white" style="float:right;" data-dismiss="modal" aria-label="Close"
                            data-toggle="close">Close</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="planned" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Planned</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="row">

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Unit</td>
                                    <td>Service type</td>
                                    <td>Service date</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    $planned = \App\Models\Services::where('service_status', 'In progress')->where('service_date', '!=', '')->where('service_type', '!=', 'Report')->where('service_type', '!=', 'Repair')->whereNull('deleted_at')->orderBy('service_date', 'asc')->get();

                    if ($planned) {
                        foreach ($planned as $x) {
                            $unit = \App\Models\Units::where('unit', $x->unit)->whereNull('deleted_at')->first();

                            echo "<tr>";
                            echo "<td>".$x->unit."</td>";
                            echo "<td>".$x->service_type."</td>";
                            echo "<td>".$x->service_date."</td>";
                            echo "<td><a href='/services/".$x->id."/edit'>View</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                            </tbody>

                        </table>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-white" style="float:right;" data-dismiss="modal" aria-label="Close"
                            data-toggle="close">Close</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
