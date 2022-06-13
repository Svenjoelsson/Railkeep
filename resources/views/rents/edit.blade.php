@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit agreement</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($rent, ['route' => ['rents.update', $rent->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('rents.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('rents.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}
            
        </div>
        <div class="card card-body">
        <div class="row">
            <div class=" col-6">
                    <h3 style=";">Comments</h3>
                    @include('comments')
            </div>
            <div class="col-6">
                    <h3 style=";">File upload</h3>
            </div>
        </div>
        </div>
    </div>
@endsection
