@extends('layouts.app')
@section('title', 'Inbound Screen')
@section('content')


@if($errors->has('rack.*'))
<div class="alert alert-danger alert-block" >
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ $errors->first('rack.*') }}</strong>
</div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
@endif
<!-- <form method="POST" action="{{ route('updateRacks') }}" class="form-inline"> -->
<div class="form-inline">
    @csrf
    <div class="row">
    <label for="email" class="col-md-1">Date:</label> 
    <input type="text" name="date" class="form-control col-md-2" value="<?php echo date('d/m/Y'); ?>" readonly>
    <label for="email" class="col-md-2">Challan No:</label> 
    <input type="text" name="challan" class="form-control col-md-2 challanNo" >
    
    <label for="email" class="col-md-2">Sku Scan:</label> 
    <input type="text" name="sku"  class="form-control col-md-2 skuscan" >
    </div>
<!-- </form> -->
</div>
<br/>
<div class="row">
    <div class="col-md-12 text-left">
        <!-- <button type="button" class="btn btn-primary addRow">
            {{ __('Add Row') }}
        </button> -->
    </div>
</div>

<div class="inbrows">
<div class="row text-center mt-3">
    <div class="col-md-3">
        SKU
    </div>
    <div class="col-md-3">
        Quantity
    </div>
    <div class="col-md-3">
        Suggested Space
    </div>
</div>
</div>
@endsection
<script>
localStorage.setItem('rack', JSON.stringify(<?php echo json_encode($rack); ?>));
localStorage.setItem('skus', JSON.stringify(<?php echo json_encode($skus); ?>));
@if ($revmoeRack = Session::get('remove'))
var removeRack = '{{ $revmoeRack }}';
@endif
</script>
