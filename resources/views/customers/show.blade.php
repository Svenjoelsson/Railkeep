@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $customers->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('customers.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#vendor" role="tab" aria-controls="home" aria-selected="true">Contacts</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="units-tab" data-toggle="tab" href="#unit" role="tab" aria-controls="units" aria-selected="false">Units</a>
            </li>

            
          </ul>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="v-pills-tabContent">
                            
                            <div class="tab-pane fade show active" id="vendor" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <h4>Contact persons</h4>
                                <br />
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>

                                        </tr>
                                    </thead>
                                <?php 
                                //return Datatables::collection(User::all())->make(true);
                                // should be changed..
                                $company = $customers->name;
                                $contact = \App\Models\Contacts::where('customer', $company)->get();
                                foreach ($contact as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>".$value['name']."</td>";
                                    echo "<td><a href='#'>".$value['phone']."</a></td>";
                                    echo "<td><a href='#'>".$value['email']."</a></td>";
                                    echo "</tr>";
                                };
                                ?>
                                </table>
                            </div>
                            <div class="tab-pane fade show active" id="unit" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
