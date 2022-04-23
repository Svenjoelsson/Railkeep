@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid" style="overflow: auto !important;">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Service log</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="container-fluid shadow-lg card card-body">
            @include('services.table')

            <div class="clearfix">
                <div class="float-right">
                    
                </div>
            </div>
        </div>
    </div>

@endsection

