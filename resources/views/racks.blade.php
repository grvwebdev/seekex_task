@extends('layouts.app')
@section('title', 'Racks Order')
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
<form method="POST" action="{{ route('updateRacks') }}">
    @csrf
    
    @foreach($racks as $rack)
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">{{$rack->name}}</label>

            <div class="col-md-6">
                <input type="text" class="form-control @error('rack.{{$rack->name}}') is-invalid @enderror" name="rack[{{$rack->id}}]" required autocomplete="current-password" value="{{$rack->distance_rank}}">

                @error('rack.{{$rack->name}}')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    @endforeach
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
</form>
@endsection
