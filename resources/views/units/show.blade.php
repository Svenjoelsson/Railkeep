@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 style="float:left;">{{ $units->unit }} </h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-default float-right" href="{{ route('units.index') }}">
                    Back
                </a>
            </div>
        </div>
        @if ($noCounterUpdate == '1')
        <div class="alert alert-danger" role="alert">
            Counter has not been updated for the last 24h, please check the connection to tracking system.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

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
                aria-selected="true">Service plan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="repairs-tab" data-toggle="tab" href="#repairs" role="tab" aria-controls="repairs"
                aria-selected="true">Repairs & Reports</a>
        </li>
        @if(auth()->user()->hasPermissionTo('view reports'))
        <li class="nav-item">
            <a class="nav-link" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment"
                aria-selected="false">Comments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="profile"
                aria-selected="false">Activity log</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" id="counter-tab" data-toggle="tab" href="#counter" role="tab" aria-controls="counter"
                aria-selected="false">Counters</a>
        </li>
        @if(auth()->user()->hasPermissionTo('view reports'))
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="contact"
                aria-selected="false">File upload</a>
        </li>
        <?php
        $count = \App\Models\inventory::where('unit', $units->unit)->count();
        $x = \App\Models\Activities::where('activity_type', 'LIKE', 'Part%')->where('activity_id', $units->id)->first();
        ?>
        <li class="nav-item">
                @if ($x) 
                <a class="nav-link bg-red" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab"
                aria-controls="inventory" aria-selected="false">Parts <i style="color:white;" class="fas fa-exclamation"></i></a>
                @else
                <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab"
                aria-controls="inventory" aria-selected="false">Parts ({{ $count }})</a>
                
                @endif
            </a>
        </li>
        <li class="nav-item">
            @if ($units->inService == '0')
            <a href="/units/inservice/{{ $units->id }}/1" class="nav-link bg-red">Out of service</a>
            @else
            <a href="/units/inservice/{{ $units->id }}/0" class="nav-link bg-success">In service</a>
            @endif </li>
        @endif
    </ul>
        </div>
    </nav>
    <div class="card rounded-0">

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="services" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            @if(auth()->user()->hasPermissionTo('view reports'))
                            <a class="btn btn-primary" style="float:right; margin-right:5px;"
                                href="{{ route('makeLists.create', ['make' => $units->make]); }}">Manage</a>
                            @endif
                            <a class="btn btn-default" style="float:right; margin-right:5px;"
                                href="/units/servicePlan/<?php echo $units->id ?>/download">Export</a>
                            <h5><span style="float:left;" class="badge badge-dark">Current counter:
                                    {{ $activities->activity_message." ".$units->maintenanceType  }}</span></h5>
                            <br /><br /><br />
                            <table class="table table-hover">
                                <thead class="activeNav">
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
                              $counterNinty = \App\Models\Activities::where('activity_id', $units->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-'.$value1->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                              $dateNinty = \App\Models\Activities::where('activity_id', $units->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-'.$value1->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();

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
                            <span style='font-size:12px; margin-left:1%;' class='badge bg-primary'>* = Planned
                                service</span>
                        </div>
                        <div class="tab-pane fade" id="activities" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">

                            <table class="table table-hover">
                                <thead class="activeNav">
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
                            $unitData = \App\Models\Activities::where('activity_type', 'Unit')->where('activity_id', $id)->orderBy('created_at', 'desc')->get();
                            //$unitData = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', '%-counter-%')->orWhere('activity_type', 'like', '%-date-%')->orWhere('activity_type', 'Unit')->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();

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

                        <div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
                            @include('comments')
                        </div>

                        <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="v-pills-upload-tab">
                            <button type="button" class="btn btn-primary" style="float:right;" data-toggle="modal"
                                data-target="#newinventory">
                                Mount part
                            </button><br /><br />
                            <table class="table table-hover">
                                <thead class="activeNav">
                                    <tr>
                                        <th scope="col">Part number</th>
                                        <th scope="col">Part name</th>
                                        <th scope="col">Mounted date</th>
                                        <th scope="col">Counter</th>
                                        <th scope="col">Next maintenance counter</th>
                                        <th scope="col">Next maintenance date</th>
                                        <th scope="col">EOL Counter</th>
                                        <th scope="col">EOL Date</th>
                                        <th scope="col">Status</th>
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
                              $part = \App\Models\InventoryLog::where('part', $value["id"])->first();

                              echo "<td>".$part->dateMounted."</td>";
                              echo "<td>".$part->counter." ".$units->maintenanceType."</td>";
                              echo "<td>".$value['maintenance']." ".$units->maintenanceType."</td>";
                              echo "<td>".$value['maintenanceDate']."</td>";
                              echo "<td>".$value['eol']."</td>";
                              echo "<td>".$value['eolDate']."</td>";
                              $x = \App\Models\Activities::where('activity_type', 'LIKE', 'Part%')->where('activity_id', $units->id)->where('activity_message', $part->part)->first();
                              if ($x) {
                                if (str_contains($x->activity_type, 'Critical')) {
                                    echo '<td><span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span></a></td>';
                                } else {
                                    echo '<td><span style="font-size:16px;" class="badge bg-warning"><i style="color:white;" class="fas fa-exclamation"></i></span></a></td>';
                                }
                              } else {
                                echo '<td><span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a></td>';

                              }

                              echo "</tr>";
                          };
                          ?>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="counter" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <table class="table table-hover">
                                <thead class="activeNav">
                                    <tr>
                                        <th scope="col">Counter</th>
                                        <th scope="col">Timestamp</th>
                                    </tr>
                                </thead>
                                <?php 
                            //return Datatables::collection(User::all())->make(true);
                            // should be changed..
                            $id = $units->id;
                            $unitData = \App\Models\Activities::where('activity_type', 'UnitCounter')->where('activity_id', $id)->orderBy('created_at', 'desc')->get()->unique('activity_message');
                            foreach ($unitData as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$value['activity_message']." ".$units->maintenanceType."</td>";
                                echo "<td>".$value['created_at']."</td>";
                                echo "</tr>";
                            };
                            ?>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="repairs" role="tabpanel" aria-labelledby="v-pills-repairs-tab">
                            <table class="table table-hover">
                                <thead class="activeNav">
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Created</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <?php 
                            //return Datatables::collection(User::all())->make(true);
                            // should be changed..
                            $id = $units->id;
                            $unitData = \App\Models\Services::where('service_type', 'LIKE', 'Rep%')->where('unit', $unit)->orderby('service_status', 'desc')->orderBy('created_at', 'desc')->get();
                            
                            foreach ($unitData as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$value['service_type']."</td>";
                                $out = strlen($value['service_desc']) > 50 ? substr($value['service_desc'],0,50)."..." : $value['service_desc'];
                                echo "<td>".$out."</td>";
                                echo "<td>".$value['created_at']."</td>";
                                echo "<td>".$value['service_status']."</td>";
                                echo "<td><a class='btn btn-default btn-xs' href='/services/".$value['id']."/edit'><i class='fa fa-edit'></i></a></td>";
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










<div class="modal fade" id="newinventory" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mount part</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form method="post" action="{{url('inventories/mount')}}" accept-charset="UTF-8">
                <input type="hidden" name="unit" value="{{ $unit }}">
                @csrf <!-- {{ csrf_field() }} -->
              <label for="part">Select part</label>
              <select name="part" class="form-control js-example-basic-single-modal" id="part">
                <option></option>
              
            <?php 
            $unitData = \App\Models\inventory::whereNull('unit')->orderBy('partName', 'asc')->get();
            foreach ($unitData as $value) {
              echo "<option value='".$value['id']."'>".$value['partName']." (Part: ".$value['partNumber']." Batch: ".$value['batch'].")</option>";
            }
            ?>
            </select>

            <label for="date">Mount date</label>
            <input type="text" name="mountDate" class="form-control datepicker">

            <label for="date">Comment</label>
            <textarea name="comment" class="form-control"></textarea>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        });       
        
    </script>
@endpush

@endsection
