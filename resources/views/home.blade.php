@extends('layouts.app')
@section('title', 'Home')
@section('content')
    {{ __('Welcome to Inventory Space Allocation Web Application') }}
    <br/><br/><br/>
    <h5>Racks</h5>
    <table class="table ">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Capacity</th>
        <th scope="col">RC</th>
        <th scope="col">RD</th>
        <th scope="col">Coefficient S</th>
        <th scope="col">Loaded</th>
        </tr>
    </thead>
    @foreach($racks as $rack)
    <tr>
      <td>{{$rack->name}}</td>
      <td>{{$rack->capacity}}</td>
      <td>{{$rack->capacity_rank}}</td>
      <td>{{$rack->distance_rank}}</td>
      <td>{{$rack->storage_coefficient_s}}</td>
      <td>{{$rack->loaded}}</td>
    </tr>
    @endforeach
    </table>
    <br/>
    <h5>SKUs</h5>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Volumetric Size</th>
        </tr>
    </thead>
    @foreach($skus as $sku)
    <tr>
      <td>{{$sku->name}}</td>
      <td>{{$sku->volumetric_size}}</td>
    </tr>
    @endforeach
    </table>
@endsection
