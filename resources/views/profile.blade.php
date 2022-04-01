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
                <h4>Update password</h4>
                <div class="row">
                    <div class="col-4">
                        <label for="pass">Current password</label>
                        <input type="password"  id="pass" value="" class="form-control">
                    </div>
                    <div class="col-4">
                      <label for="pass1">New password</label>
                      <input type="password"  id="pass1" value="" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="pass2">Repeat password</label>
                        <input type="password" id="pass2" value="" class="form-control">
                        <br />
                        <button style="float:right;" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


