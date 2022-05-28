@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 style="float:left;">Edit service</h1>
                    <a style="float:right;" href="/services/{{ $services->id }}" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                {{ $message }}
        </div>
        @endif
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
                <span style="float:right">
                    <button type="button" class="btn disableAll btn-primary" data-toggle="modal" data-target="#workshop">
                        Workshop
                    </button>
                </span>
            </div>

            {!! Form::close() !!}

        </div>
    </div>


    <div class="modal fade" id="workshop" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Workshop</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <h4>Send to workshops</h4>
                        <form method="post" action="{{url('someurl')}}" accept-charset="UTF-8">
                            <input type="hidden" name="serviceId" value="{{ $services->id }}">
                            @csrf <!-- {{ csrf_field() }} -->
                            
                            <label>Select vendor</label><br />
                            <select name="vendor" class="form-control js-example-basic-single-modal-workshop vendorSelect">
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
                            <button type="submit" style="float:right;" class="btn btn-primary">Send</button>
                        </form>
                        </div>
                        <div class="col-8">
                            <h4>Active workshops</h4>
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
                </div> 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
          </div>
        </div>
      </div>





@endsection
