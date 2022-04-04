@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rental</h1>
                </div>
                <div class="col-sm-6">
                    <div class="dropdown">
                        <button style="float:right;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Reports
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="/reports/view/rental/returns/{{ now()->format('Y')."/".now()->format('m') }}">Returns</a>
                          <a class="dropdown-item" href="#">Invoice</a>
                        </div>
                      </div>
                      
                </div>
            </div>
            
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

            <div class="card-body p-0">
                @include('rents.table')

                <div class=" clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>
    </div>

@endsection

