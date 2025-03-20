@extends('master')
@section('title',  __('contreq.pagename13'))
@section('head')
<style>
    .row-warning {
    background-color:rgb(238, 171, 171) !important;
    border:2 px solid;
    color: #721c24; /* Dark red text */
    box-shadow: 0px 2px 5px rgba(255, 0, 0, 0.3);
}
.row-warning img {
    filter: hue-rotate(90deg); /* You can also modify the icon color using CSS if you want */
}
</style>
@endsection
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename13') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
<!-- Search Form -->
<form method="GET" action="{{ route('contractindex') }}" class="form-group p-3 flex row">
        <div class="w-25 p-3">
            <label for="search_mobile">{{ __('contreq.searchno') }}</label>
            <input type="text" id="search_mobile" name="search_mobile" value="{{ request('search_mobile') }}">
        </div>

        <div class="w-25 p-3">
            <label for="search_contract_no">{{ __('contreq.id') }}</label>
            <input type="text" id="search_contract_no" name="search_contract_no" value="{{ request('search_contract_no') }}">
        </div>
        <div class="w-25 p-3">
            <label for="search_cust_name">{{ __('contreq.custname') }}</label>
            <input type="text" id="search_cust_name" name="search_cust_name" value="{{ request('search_cust_name') }}">
        </div>
        <div class="w-25 p-3">
           
        <button  class="btn btn-outline-primary" type="submit">{{ __('contreq.search') }}</button></div>
    </form>

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.contractdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.mobno') }}</th>
                    <th>{{ __('contreq.cost') }}</th>
                    <th>{{ __('contreq.total') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracts as $contract)
                @php
                // Get the difference between the contract due date and today's date
                $dueDate = \Carbon\Carbon::parse($contract->duedate);
                $today = \Carbon\Carbon::now();
                $difference = $dueDate->diffInDays($today);
                 @endphp

                    <tr>
                        <td>{{ $contract->id }}</td>
                        <td>{{ $contract->contractdate }}</td>
                        <td>{{ $contract->custname }}</td>
                        <td>{{ $contract->mobileno }}</td>
                        <td>{{ $contract->cost }}</td>
                        <td>{{ $contract->totalInvoice }}</td>
                        
                        <td >
                            <form action="{{ route('destroycontract',$contract->id) }}" method="Post">
                                <a class="btn" href="{{ route('contractedit',$contract->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="20" height="20"> 
                                </a>
                                <a class="btn" href="{{ route('invoiceindex', $contract->id) }}"> 
                                <img src="{{ asset('images/invoice1.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @if($contract->can_add_invoice)
                                
                                <a class=" btn {{$difference <= 10 && $contract->duedate ? 'row-warning' : '' }}"  href="{{ route('createinvoice', $contract->id) }}" > 
                                <img src="{{ asset('images/invoice4.JPG') }}" alt="add" width="20" height="20">
                                </a>
                                @endif
                                <a class="btn" href="{{ route('addcontractreq', $contract->id) }}"> 
                                <img src="{{ asset('images/cont1.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @csrf
                                @method('DELETE')
                             <button type="submit" class="btn">
                             <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="20" height="20"> 
                             </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $contracts->links() !!}
    </div>
    </section><!-- /Starter Section Section -->

  </main>
</div>
@endsection
