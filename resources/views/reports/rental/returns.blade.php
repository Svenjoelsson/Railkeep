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
                          <th scope="col">Rent End</th>

                        </tr>
                      </thead>
                @foreach ($units as $unit)
                    <tr>
                        <td>{{ $unit->unit }}</td>
                        <td>{{ $unit->customer }}</td>
                        <td>{{ $unit->rentEnd }}</td>

                    </tr>
                @endforeach
                </table>  

            </div>
    </div>

@endsection

