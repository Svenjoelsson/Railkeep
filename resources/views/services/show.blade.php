@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Service</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                        href="{{ route('services.index') }}">
                        Back
                    </a>
                    <a class="btn btn-primary float-right" style="margin-right:5px;"
                        href="/services/{{ $services->id }}/edit">
                        Edit service #{{ $services->id }}
                    </a> 
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#vendor" role="tab" aria-controls="home" aria-selected="true">Vendor</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#unit" role="tab" aria-controls="profile" aria-selected="false">Comments</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#documentation" role="tab" aria-controls="contact" aria-selected="false">File upload</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#history" role="tab" aria-controls="contact" aria-selected="false">Activity log</a>
            </li>
          </ul>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                      <div class="tab-content" id="v-pills-tabContent">
                          
                        <div class="tab-pane fade show active" id="vendor" role="tabpanel" aria-labelledby="v-pills-home-tab">

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
                        <div class="tab-pane fade" id="unit" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            @include('comments')
                        </div>
                        <div class="tab-pane fade" id="documentation" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            @include('fileUpload') 
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th scope="col">Type</th>
                                      <th scope="col">Message</th>
                                      <th scope="col">Timestamp</th>
                                    </tr>
                                  </thead>
                            <?php 
                            //return Datatables::collection(User::all())->make(true);
                            // should be changed..
                            //$unitData = \App\Models\Activities::where('activity_type', 'Unit')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();
                            $act = \App\Models\Activities::Where('activity_type', 'Service')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();

                            foreach ($act as $value) {
                                echo "<tr>";
                                echo "<td>";
                                  echo $value['activity_type'];
                                echo "</td>";
                                echo "<td>";
                                  echo $value['activity_message'];
                                echo "</td>";
                                echo "<td>".$value['created_at']."</td>";
                                echo "</tr>";
                            };
                            ?>
                            </table>
                        </div>

                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
@endsection
