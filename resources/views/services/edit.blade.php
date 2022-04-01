@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Services</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($services, ['route' => ['services.update', $services->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('services.fieldsEdit')
                </div>
                <span style='font-size:12px;' class='badge badge-danger'>* = Required</span>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary disableAll']) !!}
                <a href="{{ route('services.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
