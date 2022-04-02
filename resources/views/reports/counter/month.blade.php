@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reports</h1>
                    Viewing {{ $model }} {{ $type }} @if ($period) of period {{ $period }} @endif

                    <h1>Report not working yet...</h1>
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
                          <th scope="col">Counter</th>

                        </tr>
                      </thead>
                @foreach ($counters as $counter)
                    <tr>
                        <td>{{ $counter->activity_id }}</td>
                        <td>{{ $counter->activity_message }}</td>

                    </tr>
                @endforeach
                </table>  

            </div>
    </div>

@endsection

