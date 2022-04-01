@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $units->make }}-{{ $units->unit }}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('units.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#services" role="tab" aria-controls="home" aria-selected="true">Service plan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="profile" aria-selected="false">Activities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="counter-tab" data-toggle="tab" href="#counter" role="tab" aria-controls="counter" aria-selected="false">Counters</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="contact" aria-selected="false">File upload</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="false">Inventory</a>
        </li>

      </ul>
        <div class="card">
          
            <div class="card-body">
                <div class="row">
                      <div class="col-12">
                        <div class="tab-content" id="v-pills-tabContent">
                          <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <a class="btn btn-primary" style="float:right;" href="{{ route('services.create', ['unit' => $units->unit]); }}">New service</a> 
                            <a class="btn btn-primary" style="float:right; margin-right:5px;" href="{{ route('makeLists.create', ['make' => $units->make]); }}">New type</a> 
                            <br /><br />
                            Current counter: {{ $activities->activity_message }} <br /><br />
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th scope="col">Service type</th>
                                      <th scope="col">Operational days</th>
                                      <th scope="col">Calendar days</th>
                                      <th scope="col">Counter</th>
                                      <th scope="col">Planned</th>
                                      <th scope="col"></th>
                                    </tr>
                                  </thead>
                            <?php 
                            
                            foreach ($make['make'] as $value1) {

                                $counterType = '';
                                if ($value1->counter) {
                                  $counterType = $value1->counterType;
                                }
                                echo "<tr>";
                                echo "<td><b>".$value1->serviceName."</b>";
                                echo "<br />";



                                echo "</td>";
                                echo "<td><b>".$value1->operationDays."</b></td>";
                                echo "<td>".$value1->calendarDays;
                                  if (array_key_exists($value1->serviceName, $make['services']) && $make['services'][$value1->serviceName]->nextServiceDate) {
                                    echo "<br />Due date: ";
                                    $remove = str_replace(' 00:00:00', '', $make['services'][$value1->serviceName]->nextServiceDate);
                                    echo "<a href='".route('services.edit', $make['services'][$value1->serviceName]->id)."'>".$remove."</a>";
                                  }  
                                echo "</td>";
                                echo "<td><b>".$value1->counter." ".$counterType."</b>";
                                  if (array_key_exists($value1->serviceName, $make['services']) && $value1->counter) {
                                    echo "<br />Due at: ";
                                    echo "<a href='".route('services.edit', $make['services'][$value1->serviceName]->id)."'>".$make['services'][$value1->serviceName]->nextServiceCounter."</a> ".$counterType;
                                    //var_dump($make['services'][$value1->serviceName]);

                                  }  
                                echo "</td>";
                                echo "<td>";
                                if (array_key_exists($value1->serviceName, $make['planned'])) {
                                      echo "<span style='font-size:12px; margin-right:5px;' class='badge badge-primary'><a href='".route('services.edit', $make['planned'][$value1->serviceName]->id)."'>".$make['planned'][$value1->serviceName]->service_date."</a>*</span>";
                                  }
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='".route('makeLists.edit', $value1->id)."' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>";
                                //echo "<a href='".route('services.create', ['unit' => $units->unit]) ."' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>";

                                echo "</td>";
                                echo "</tr>";


                                
                            };
                            ?>
                            </table>  
                            <span style='font-size:12px; margin-left:1%;' class='badge badge-primary'>* = Planned service</span>
                          </div>
                          <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th scope="col">Activity</th>
                                      <th scope="col">Timestamp</th>
                                    </tr>
                                  </thead>
                            <?php 
                            //return Datatables::collection(User::all())->make(true);
                            // should be changed..
                            $id = $units->id;
                            $unitData = \App\Models\activities::where('activity_type', 'Unit')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();
                            foreach ($unitData as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$value['activity_message']."</td>";
                                echo "<td>".$value['created_at']."</td>";
                                echo "</tr>";
                            };
                            ?>
                            </table>
                          </div>
                          <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="v-pills-upload-tab">
                            @include('fileUpload') 
                          </div>
                          <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="v-pills-upload-tab">
                            <button type="button" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#newinventory">
                              Create inventory
                          </button><br /><br />
                            <table class="table table-hover">
                              <thead>
                                  <tr>
                                    <th scope="col">Number</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mounted date</th>
                                  </tr>
                                </thead>
                          <?php 
                          //return Datatables::collection(User::all())->make(true);
                          // should be changed..
                          $unit = $units->unit;
                          $unitData = \App\Models\inventory::where('unit', $unit)->orderBy('created_at', 'desc')->get();
                          foreach ($unitData as $key => $value) {
                              echo "<tr>";
                              echo "<td>".$value['partNumber']."</td>";
                              echo "<td>".$value['partName']."</td>";
                              echo "<td>".$value['dateMounted']."</td>";
                              echo "</tr>";
                          };
                          ?>
                          </table>
                          </div>

                          <div class="tab-pane fade" id="counter" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th scope="col">Counter</th>
                                      <th scope="col">Timestamp</th>
                                    </tr>
                                  </thead>
                            <?php 
                            //return Datatables::collection(User::all())->make(true);
                            // should be changed..
                            $id = $units->id;
                            $unitData = \App\Models\activities::where('activity_type', 'UnitCounter')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();
                            foreach ($unitData as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$value['activity_message']." ".$units->maintenanceType."</td>";
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

    <div class="modal fade" id="newinventory" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create inventory</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding: 0;">
            <div class="row">
                          {!! Form::open(['route' => 'inventories.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('inventories.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
          </div>
              
          </div>
        </div>
      </div>
    </div>


@endsection



