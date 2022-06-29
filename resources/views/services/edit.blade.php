@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 style="float:left;">Edit service</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <nav class="navbar navbar-expand-lg">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="fa fa-bars"></span>
            </button>
          
            <div class="collapse navbar-collapse" style="margin-left:5px;" id="navbarSupportedContent">
        <ul class="nav nav-tabs navbar-nav mr-auto" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#services" role="tab" aria-controls="home"
                    aria-selected="true">Service</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="workshop-tab" data-toggle="tab" href="#workshop" role="tab" aria-controls="workshop"
                    aria-selected="true">Workshop</a>
            </li>
            @if(auth()->user()->hasPermissionTo('view reports'))
            <li class="nav-item">
                <a class="nav-link" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment"
                    aria-selected="false">Comments</a>
            </li>
            @endif

            @if(auth()->user()->hasPermissionTo('view reports'))
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="contact"
                    aria-selected="false">File upload</a>
            </li>

            @endif
        </ul>
            </div>
        </nav>

        @include('adminlte-templates::common.errors')

        <div class="card rounded-0">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="services" role="tabpanel"
                    aria-labelledby="v-pills-home-tab">
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
                <div class="tab-pane fade show" id="workshop" role="tabpanel"
                    aria-labelledby="v-pills-home-tab">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ $message }}
                            </div>
                            @endif
                            <h4>Activated vendors</h4>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th scope="col">Company</th>
                                      <th scope="col">Email</th>
                                      <th scope="col">Phone</th>
                                      <th scope="col">Timestamp</th>
                                    </tr>
                                  </thead>
                                <?php 
                                $id = $services->id;
                                $serviceVendor = \App\Models\serviceVendor::where('serviceId', $id)->orderBy('created_at', 'desc')->get();
                                foreach ($serviceVendor as $key => $value1) {
                                    echo "<tr>";
                                    $vendor = \App\Models\Vendors::where('id', $value1['vendorId'])->first();
                                    echo "<td>".$vendor->name." (".$vendor->address.")</td>";
                                    echo "<td><a href='mailto:".$vendor->contact_email."'>".$vendor->contact_email."</a></td>";
                                    echo "<td><a href='tel:".$vendor->contact_phone."'>".$vendor->contact_phone."</a></td>";
                                    echo "<td>".$value1['created_at']."</td>";
                                    echo "</tr>";
                                };
                                ?>
                            </table>
                        </div>
                        <div class="col-5">
                            <form method="post" action="{{url('someurl')}}" accept-charset="UTF-8">
                                <input type="hidden" name="serviceId" value="{{ $services->id }}">
                                @csrf <!-- {{ csrf_field() }} -->
                                
                                <label>Select vendor</label><br />
                                <select name="vendor" class="form-control js-example-basic-single vendorSelect">
                                    <option></option>
                                <?php 
                                $vendors = \App\Models\Vendors::all();
                                foreach ($vendors as $key => $value) {
                                    echo "<option value='".$value["name"]."'>".$value["name"]." (".$value["address"].")</option>";
                                };
                                ?>
                                </select><br /><br />
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" id="vendorEmail"><br />
                                <label>Message to vendor</label>
                                <textarea name="message" class="form-control"></textarea><br />
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade show" id="comment" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="card-body">
                    @include('comments')
                </div>
            </div>
            <div class="tab-pane fade show" id="upload" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="card-body">
                    @include('fileUpload')
                </div>
            </div>
            </div>
        </div>
    </div>





@endsection
