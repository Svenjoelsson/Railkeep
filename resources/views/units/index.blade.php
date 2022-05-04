@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Units</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

            <!--<div class="card-body p-0">-->
                <div class="container-fluid shadow-lg card card-body">
                @include('units.table')

                <div class="clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>
    </div>
    <span style='font-size:12px; margin-left:1%;' class='badge bg-primary'>* = Planned service</span>


    <script>

        $('.custom-select').change(function(){
            var data= $(this).val();
            alert(data);            
        });
    </script>

@endsection

