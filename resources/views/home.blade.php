@extends('master')
@section('title',  __('contreq.pagename49'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename49') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
    <div class="col-md-4">
        <div class="alert alert-info">Available Containers: {{ $availableCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-primary">Rented Containers: {{ $rentedCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-success">Active Rentals (not expired): {{ $activeRentalCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-warning">Full Containers: {{ $fullCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-dark">Left Containers: {{ $leftCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-danger">Not Empty Containers: {{ $notEmptyCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-info">Expire resedence after 1 month: {{ $expiringCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-primary">Expire resedence : {{ $expiringCount1 }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-success">Expire drivercard after 1 month: {{ $expiringdCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-warning">Expire drivercard: {{ $expiringdCount1 }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-dark">Expire carexamin after 1 month: {{ $expiringeCount }}</div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-danger">Expire carexamin: {{ $expiringeCount1 }}</div>
    </div>
</div>
        
       
    </div>
    

  </main>

</div>
@endsection