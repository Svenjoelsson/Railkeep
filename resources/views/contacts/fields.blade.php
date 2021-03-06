<!-- Customer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer', 'Customer: *') !!} <span style="float:right"><small><a href="/customers/create">Create new</a></small></span>
    <?php 
    if (Auth::user()->role == 'customer') {
        $customers = \App\Models\Customers::where('name', Auth::user()->name)->get();
    } else {
        $customers = \App\Models\Customers::all();
    }
    foreach ($customers as $key => $value) {
        $arr[$value['name']] = $value['name'];
    }
    ?>
    {!! Form::select('customer', $arr, null, ['class' => 'form-control js-example-basic-single', 'required', 'placeholder' => 'Select customer']) !!}
    
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name: *') !!}
    {!! Form::text('name', null, ['class' => 'form-control' , 'required']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email: *') !!}
    {!! Form::email('email', null, ['class' => 'form-control' , 'required']) !!}
</div>