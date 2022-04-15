@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('dashboard') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                      <label for="name">Name</label>
                      <input type="text" disabled id="name" value="{{ Auth::user()->name }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="email">Email</label>
                        <input type="text" disabled id="email" value="{{ Auth::user()->email }}" class="form-control">
                    </div>
                </div><br />
                <div class="row">
                    <div class="col-6">
                      <label for="name">User created</label>
                      <input type="text" disabled id="name" value="{{ Auth::user()->created_at->format('Y-m-d') }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="email">User updated</label>
                        <input type="text" disabled id="email" value="{{ Auth::user()->updated_at }}" class="form-control">
                    </div>
                </div>

                <hr>
                <h4>Profile photo</h4>
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ $message }}
                </div>
                @endif
                
                <form action="{{ route('profile.photo.post') }}" method="POST" enctype="multipart/form-data">
                    <div class="col-6">
                    <div class="custom-file">
                        <input type="file" name="photo" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    @csrf<br /><br />
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
                </div>

            </div>
        </div>
    </div>
@endsection


