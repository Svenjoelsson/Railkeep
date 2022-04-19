@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $units->unit }}</h1>
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
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="profile" aria-selected="false">Activity log</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="counter-tab" data-toggle="tab" href="#counter" role="tab" aria-controls="counter" aria-selected="false">Counters</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="contact" aria-selected="false">File upload</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="false">Parts</a>
        </li>

      </ul>
        <div class="card">
          
            <div class="card-body">
                <div class="row">
                      <div class="col-12">
                        <div class="tab-content" id="v-pills-tabContent">
                          <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="v-pills-home-tab">

                            <a class="btn btn-primary" style="float:right; margin-right:5px;" href="{{ route('makeLists.create', ['make' => $units->make]); }}">Manage</a> 
                            <a class="btn btn-default" style="float:right; margin-right:5px;" href="/units/servicePlan/<?php echo $units->id ?>/download">Export</a> 

                            <h5><span style="float:left;" class="badge badge-dark">Current counter: {{ $activities->activity_message." ".$units->maintenanceType  }}</span></h5>
                             <br /><br /><br />
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
                              $counterNinty = \App\Models\Activities::where('activity_id', $units->id)->where('activity_type', 'like', '90%-counter-'.$value1->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                              $dateNinty = \App\Models\Activities::where('activity_id', $units->id)->where('activity_type', 'like', '90%-date-'.$value1->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();

                              $counterOverdue = \App\Models\Activities::where('activity_id', $units->id)->where('activity_type', 'like', 'Overdue-counter-'.$value1->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                              $dateOverdue = \App\Models\Activities::where('activity_id', $units->id)->where('activity_type', 'like', 'Overdue-date-'.$value1->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();    


                                $counterType = '';
                                if ($value1->counter) {
                                  $counterType = $value1->counterType;
                                }
                                echo "<tr>";
                                  echo "";
                                echo "<td><a href='".route('makeLists.edit', $value1->id)."'>".$value1->serviceName."</a>";
                                echo "<br />";



                                echo "</td>";
                                echo "<td><b>".$value1->operationDays."</b></td>";
                                echo "<td>".$value1->calendarDays;
                                  ########## DATE ##########
                                  if (array_key_exists($value1->serviceName, $make['services']) && $make['services'][$value1->serviceName]->nextServiceDate) {
                                    echo "<br />Due date: ";
                                    $remove = str_replace(' 00:00:00', '', $make['services'][$value1->serviceName]->nextServiceDate);
                                    echo "<a href='".route('services.edit', $make['services'][$value1->serviceName]->id)."'>".$remove."</a>";
                                    if ($dateOverdue) {
                                      echo " <span class='badge bg-danger'>Overdue</span>";
                                    }
                                    if ($dateNinty) {
                                      echo " <span class='badge bg-warning' style='color:white !important;'>Upcoming</span>";
                                    }

                                  }  
                                echo "</td>";
                                echo "<td><b>".$value1->counter." ".$counterType."</b>";
                                  ########## COUNTER ##########
                                  if (array_key_exists($value1->serviceName, $make['services']) && $value1->counter) {
                                    echo "<br />Due in: ";
                                    echo "<a href='".route('services.edit', $make['services'][$value1->serviceName]->id)."' data-toggle='tooltip' title='Due at: ".$make['services'][$value1->serviceName]->nextServiceCounter."'>".(intval($make['services'][$value1->serviceName]->nextServiceCounter) - intval($activities->activity_message))."</a> ".$units->maintenanceType;
                                    // echo "<a href='".route('services.edit', $make['services'][$value1->serviceName]->id)."'>".$make['services'][$value1->serviceName]->nextServiceCounter."</a> ".$counterType;
                                    if ($counterOverdue) {
                                      echo " <span class='badge bg-danger'>Overdue</span>";
                                    } 
                                    if ($counterNinty) {
                                      echo " <span class='badge bg-warning' style='color:white !important;'>Upcoming</span>";
                                    }
                                    
                                    //var_dump($make['services'][$value1->serviceName]);

                                  }  
                                echo "</td>";
                                echo "<td>";
                                if (array_key_exists($value1->serviceName, $make['planned'])) {
                                      echo "<span style='font-size:12px; margin-right:5px;' class='badge badge-primary'><a href='".route('services.edit', $make['planned'][$value1->serviceName]->id)."'>".$make['planned'][$value1->serviceName]->service_date."</a>*</span>";
                                  }
                                echo "</td>";
                                echo "<td><div class='btn-group'>";
                                echo "<a href='".route('services.create', ['unit' => $units->unit, 'service_type' => $value1->serviceName])."' class='btn btn-default btn-xs'><i class='fa fa-plus'></i></a>";
                                echo "</div>";
                                //echo "<a href='".route('services.create', ['unit' => $units->unit]) ."' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>";

                                echo "</td>";
                                echo "</tr>";


                                
                            };
                            ?>
                            </table>  
                            <span style='font-size:12px; margin-left:1%;' class='badge bg-primary'>* = Planned service</span>
                          </div>
                          <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="v-pills-profile-tab">

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
                            $id = $units->id;
                            //$unitData = \App\Models\Activities::where('activity_type', 'Unit')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();
                            $unitData = \App\Models\Activities::Where('activity_type', 'like', '%-counter-%')->orWhere('activity_type', 'like', '%-date-%')->orWhere('activity_type', 'Unit')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();

                            foreach ($unitData as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$value['activity_type']."</td>";
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
                              Create part
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
                            $unitData = \App\Models\Activities::where('activity_type', 'UnitCounter')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();
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
            <h5 class="modal-title" id="exampleModalLabel">Create part</h5>
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




