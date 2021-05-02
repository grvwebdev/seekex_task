<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('racks') }}">{{ __('Racks Order') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inbound') }}">{{ __('Inbound Screen') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header  text-center">@yield('title')</div>
                    <div class="card-body text-center">
                        @yield('content')
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>
</body>
<script>
$(document).ready(function(){
    var inboundData = getInboundData();
    $('.challanNo').val(localStorage.getItem('challanNo'));
    if(inboundData != null){
        Object.keys(inboundData).forEach(function(key) {
            addRow(inboundData[key].sku, inboundData[key].volSize, inboundData[key].quantity, inboundData[key].suggestedSpace);
        });
    }
})
function trim(str){
    return str.replace(/^\s+|\s+$/g,"");
}

$('body').on('keydown', '.skuscan, .challanNo', function(e){
    if(e.which == 13){
        var me = $(this);
        var challanNo = trim($('.challanNo').val());
        if(challanNo == ""){
            alert('Please enter the challan no.');
            return;
        }
        var skuNo = trim($('.skuscan').val()).toUpperCase();
        if(skuNo == ""){
            alert('Please enter the SKU no.');
            return;
        }
        addUpdateData(skuNo, challanNo);
        $('.skuscan').val('');
    }
});

function addUpdateData(SKU, challanNo){
    var rack = JSON.parse(localStorage.getItem("rack"));
    if(rack == null){
        alert('no rack available');
        return;
    }
    var inboundData = getInboundData();
    var volSize = 0;
    var SKUs = JSON.parse(localStorage.getItem("skus"));
    var skuValid = false;
    var rackCapacity = parseFloat(rack.capacity);
    var capacityLimit = rackCapacity * 0.90;
    Object.keys(SKUs).forEach(function(key) {
        if(SKUs[key].name == SKU){
            skuValid = true;
            volSize = parseFloat(SKUs[key].volumetric_size);
        }
    });
    if(inboundData == null){ // add sku data
        var inboundData = [{'sku': SKU, 'quantity':1, 'volSize':volSize, 'reachedCapacity':false, 'suggestedSpace':''}];
        addRow(SKU, volSize);
    }else{
        var skuExists = false;
        if(!skuValid){
            alert('Sku not found in database');
            return;
        }
        //check if capacity reached
        anyCapacityReached = false;
        Object.keys(inboundData).forEach(function(key) {
            if(inboundData[key].reachedCapacity === true){
                anyCapacityReached = true;
            }
        });
        if(anyCapacityReached === true){
            alert('capacity reached, to continue, please move products to rack '+rack.name)
            return false;
        }
        // if capacity not reached continue adding garments
        Object.keys(inboundData).forEach(function(key) {
            if(inboundData[key].sku == SKU){
                newq = inboundData[key].quantity = inboundData[key].quantity+1;
                newc = inboundData[key].volSize += volSize;
                news = '';
                if(newc >= capacityLimit){
                    inboundData[key].reachedCapacity=true;
                    news = inboundData[key].suggestedSpace=rack.name;
                }
                updateRow(SKU, newc, newq, news);
                skuExists = true;
            }
        });
        // update inbound with new sku entries if any inbound data exists
        if(skuExists===false){
            inboundData.push({'sku': SKU, 'quantity':1, 'volSize':volSize, 'reachedCapacity':false, 'suggestedSpace':''});
            addRow(SKU, volSize);
        }
    }
    localStorage.setItem('challanNo', challanNo);
    setInboundData(inboundData);
}

function setInboundData(inboundData){
    localStorage.setItem('inboundData', JSON.stringify(inboundData));
}
function getInboundData(inboundData){
    var data = localStorage.getItem("inboundData");
    if(data != null){
        inboundData = JSON.parse(data);
        if(typeof removeRack != 'undefined' && removeRack != null) {
            var newArr = [];
            Object.keys(inboundData).forEach(function(key) {
                if(inboundData[key].suggestedSpace !== removeRack){
                    newArr.push(inboundData[key]);
                }
            });
            setInboundData(newArr);
            inboundData = newArr;
        }
        return inboundData;
    }
    return data;
}
function addRow(SKU, volSize, quantity=1,suggestedRack=''){
    var subBtn = '';
    if(suggestedRack!=""){
        subBtn = '<div class="col-md-3 col">'
                +'<input type="submit" name="submit" class="btn btn-primary" value="Done" readonly>'
            +'</div>';
    }
    var row = '<div class=" text-center mt-3 sku-'+SKU+'">' 
            +'<form method="POST" action="update_inbound" class="row">@csrf'
            +'<div class="col-md-3 col">'
                +'<input type="text" name="sku" class="form-control" value="'+SKU+'" readonly>'
            +'</div>'
            +'<div class="col-md-3 col">'
                +'<input type="text" name="quantity" class="form-control" value="'+quantity+'" readonly>'
            +'</div>'
            +'<div class="col-md-3 col">'
                +'<input type="text" name="rack" class="form-control" value="'+suggestedRack+'" readonly>'
                +'<input type="hidden" name="spacetaken" value="'+volSize+'" readonly>'
            +'</div>'
            +subBtn
            +'</form>'
            +'</div>';
    $('.inbrows').append(row);
}

function updateRow(SKU, newc, quantity, suggestedSpace=''){
    $('.sku-'+SKU+' .col input[name=quantity]').val(quantity);
    $('.sku-'+SKU+' .col input[name=spacetaken]').val(newc);
    if(suggestedSpace !=''){
        $('.sku-'+SKU+' .col input[name=rack]').val(suggestedSpace);
        subBtn = '<div class="col-md-3 col">'
                +'<input type="submit" name="submit" class="btn btn-primary" value="Done" readonly>'
            +'</div>';
        $('.sku-'+SKU+' .row').append(subBtn);
    }
}
</script>
</html>
