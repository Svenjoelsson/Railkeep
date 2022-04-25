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
                <div class="info-box shadow-lg bg-gradient-warning">
                    <span class="info-box-icon"><i style="color:white !important;" class="fa fa-exclamation"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:white !important;">Over
                            {{ env('THRESHOLD_SOON_OVERDUE') }}% reached</span>
                        <span class="info-box-number" style="color:white !important;">{{ $ninty }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-blue">
                    <span class="info-box-icon"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Planned</span>
                        <span class="info-box-number">{{ $planned }}</span>
                    </div>

                </div>

            </div>

            <div class="col-md-2 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-danger">
                    <span class="info-box-icon"><i class="fas fa-ban"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Overdue</span>
                        <span class="info-box-number">{{ $overdue }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-12">
                <div class="info-box shadow-lg bg-gradient-danger">
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
            </div>
        </div>
    </div>
</section>
@endsection
