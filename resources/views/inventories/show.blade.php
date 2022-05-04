@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Part</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('inventories.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">Mount</a>
            </li>
        </ul>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">   

                                Overview 
                            
                            </div>
                            <div class="tab-pane fade show" id="status" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <form method="post" action="inventory/mount" accept-charset="UTF-8">
                                    <input type="hidden" name="partId" value="{{ $inventory->id }}">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    
                                    <label>Select unit</label><br />
                                    <select name="unit" class="form-control js-example-basic-single vendorSelect">
                                        <option></option>
                                    <?php 
                                    $units = \App\Models\Units::all();
                                    foreach ($units as $key => $value) {
                                        echo "<option value='".$value["id"]."'>".$value["unit"]."</option>";
                                    };
                                    ?>
                                    </select><br /><br />
                                    <label>Mounting date</label>
                                    <input type="text" class="service_date form-control" name="date"><br />
                                    <label>Comment</label>
                                    <textarea name="comment" class="form-control"></textarea><br />
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $( document ).ready(function() {


        $('.service_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            useCurrent: true,
            showTodayButton: true,
            showClear: true,
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-clock-o",
                clear: "fa fa-trash-o"
            }
        });
    });
</script>
@endsection
