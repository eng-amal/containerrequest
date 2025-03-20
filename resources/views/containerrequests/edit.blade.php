@extends('master')
@section('title',  __('contreq.pagename5'))
@section('head')

  <style>
        /* Basic styling for the modal */
        #customerModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 50px;
        }
        #modalContent {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }
    </style>
    @endsection
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename5') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('containerrequests.index') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('containerrequests.update',$containerrequest->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            @method('PUT')
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.reqdate') }}</strong>
                        <input type="datetime-local" name="reqdate" value="{{ $containerrequest->reqdate }}" class="form-control" readonly placeholder="requestdate">
                        @error('reqdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input type="text" name="custname" readonly value="{{ $containerrequest->custname }}" class="form-control" placeholder="{{ __('contreq.custname') }}">
                        @error('custname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobno" readonly value="{{ $containerrequest->mobno }}" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input type="text" name="whatno" readonly value="{{ $containerrequest->whatno }}" class="form-control" placeholder="{{ __('contreq.whatno') }}">
                        @error('whatno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contsizeid') }}</strong>
                        <select id="contsizeid" name="contsizeid" class="form-select">
                         <option value="">{{ __('contreq.contsizeid') }}</option>
                          @foreach ($containersizes as $cont)
                          <option value="{{ $cont->id }}" {{ $containerrequest->contsizeid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('contsizeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contid') }}</strong>
                        <select id="contid" name="contid" class="form-select">
                         <option value="">{{ __('contreq.contid') }}</option>
                          @foreach ($containers as $conta)
                          
                          <option value="{{ $conta->id }}" {{ $containerrequest->contid == $conta->id ? 'selected' : '' }}>
                        {{ $conta->no }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('contid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
              
                   
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" name="cityid" class="form-select">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($citys as $city)
                          <option value="{{ $city->id }}" {{ $containerrequest->cityid == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('cityid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.street') }}</strong>
                        <select id="streetid" name="streetid" class="form-select">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($streets as $street)
                          <option value="{{ $street->id }}" {{ $containerrequest->streetid == $street->id ? 'selected' : '' }}>
                        {{ $street->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('streetid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @if(!$containerrequest->contractid)
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytypeid" name="paytypeid" class="form-select">
                         <option value="">{{ __('contreq.paytype') }}</option>
                          @foreach ($paytypes as $paytyp)
                          <option value="{{ $paytyp->id }}" {{ $containerrequest->paytypeid == $paytyp->id ? 'selected' : '' }}>
                        {{ $paytyp->name }}
                          </option>
                         @endforeach
                        </select>
                        @error('paytypeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.cost') }}</strong>
                        <input type="text" name="cost" value="{{ $containerrequest->cost }}" class="form-control" placeholder="{{ __('contreq.cost') }}">
                        @error('cost')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3" id="bankdiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.bank') }}</strong>
                        <select id="bankid" name="bankid" class="form-select" >
                         <option value="" selected="selected">{{ __('contreq.bank') }}</option>
                         @foreach ($banks as $bank)
                          <option value="{{ $bank->id }}" {{ $containerrequest->bankid == $bank->id ? 'selected' : '' }}>
                        {{ $bank->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('bankid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                    <div class="w-50 p-3" id="transferdiv" name="transferdiv" style="display: none;">
                        <strong>{{ __('contreq.transferimg') }}</strong>
                        <input type="file" name="transferimg" value="{{ $containerrequest->transferimg }}" class="form-control" placeholder="{{ __('contreq.transferimg') }}">
                        @error('transferimg')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3" id="paymountdiv" name="paymountdiv" style="display: none;">
                        <strong>{{ __('contreq.payamount') }}</strong>
                        <input type="text" name="payamount" value="{{ $containerrequest->payamount }}" class="form-control" placeholder="{{ __('contreq.payamount') }}">
                        @error('payamount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3">
                    <a href="{{ $containerrequest->contlocation }}" target="_blank">{{ __('contreq.location_url') }}</a></div>
                    <div class="w-50 p-3">
                        <input type="text" name="contlocation" value="{{ $containerrequest->contlocation }}" class="form-control"  placeholder="Paste Google Maps Location URL here">
                        @error('contlocation')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.empid') }}</strong>
                        <select id="empid" name="empid" class="form-select">
                         <option value="">{{ __('contreq.empid') }}</option>
                          @foreach ($emps as $emp)
                          <option value="{{ $emp->id }}" {{ $containerrequest->empid == $emp->id ? 'selected' : '' }}>
                        {{ $emp->fullname }}
                          </option>
                         @endforeach
                        </select>
                        @error('empid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="row flex">
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.fromdate') }}</strong>
                        <input type="datetime-local" name="fromdate" value="{{ $containerrequest->fromdate }}" class="form-control" placeholder="fromdate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input type="datetime-local" name="todate" value="{{ $containerrequest->todate }}" class="form-control" placeholder="todate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                    <div class="w-25 p-3">
                <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div>
            
        </form>
    </div>

   

  </main>
 </div>
  @endsection
  @section('scripts')
 
  <script>
$(document).ready(function(){
    // When the first dropdown changes
    $('#contsizeid').on('change', function(){
        var selectedValue = $(this).val(); // Get the selected value from first dropdown
        $('#contid').append('<option value="">Select a container1:</option>');
        // Check if a value is selected
        if(selectedValue) {
            // Send an AJAX request to get the second select options based on the first select
            $('#contid').append('<option value="">Select a container2:</option>');
            $.ajax({
                url: '/get-containers',  // Define your route here
                type: 'GET',
                data: { contsid: selectedValue },
                success: function(response) {
                    // Empty the second select before appending new options
                    $('#contid').empty();

                    // Add a default option
                    $('#contid').append('<option value="">Select a container3:</option>');
                    
                    // Populate the second select options from the server response
                    response.options.forEach(function(container) {
                        $('#contid').append('<option value="' + container.id + '">' + container.no + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#contid').append('<option value="">' + error + '</option>');
                    $('#contid').append('<option value="">Select error:</option>');
                }
            });
        } else {
            // If no value is selected, clear the second select options
            $('#streetid').empty().append('<option value="">Select aaa street:</option>');
        }
    });
});
</script>
  
    <script>
        // Function to toggle the language between English and Arabic
        function toggleLanguage() {
            let currentLang = "{{ app()->getLocale() }}"; // Get current language (English or Arabic)
            let newLang = currentLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

            // Add the new language to the form as a hidden input
            let form = document.getElementById('language-form');
            let langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.name = 'lang';
            langInput.value = newLang;
            form.appendChild(langInput);

            // Submit the form to reload the page with the new language
            form.submit();
        }
    </script>
<script>
$(document).ready(function(){
    // When the first dropdown changes
    $('#cityid').on('change', function(){
        var selectedValue = $(this).val(); // Get the selected value from first dropdown
        $('#streetid').append('<option value="">Select astreet:</option>');
        // Check if a value is selected
        if(selectedValue) {
            // Send an AJAX request to get the second select options based on the first select
            $('#streetid').append('<option value="">Select astreet2:</option>');
            $.ajax({
                url: '/get-streets',  // Define your route here
                type: 'GET',
                data: { cityid: selectedValue },
                success: function(response) {
                    // Empty the second select before appending new options
                    $('#streetid').empty();

                    // Add a default option
                    $('#streetid').append('<option value="">Select astreet:</option>');
                    
                    // Populate the second select options from the server response
                    response.options.forEach(function(street) {
                        $('#streetid').append('<option value="' + street.id + '">' + street.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#streetid').append('<option value="">' + error + '</option>');
                    $('#streetid').append('<option value="">Select error:</option>');
                }
            });
        } else {
            // If no value is selected, clear the second select options
            $('#streetid').empty().append('<option value="">Select aaa street:</option>');
        }
    });
});
</script>
<script>
 $(document).ready(function() {
            var payId = $('#paytypeid').val(); // Get the selected city ID

            if (payId === '3' ||payId === '6')
             {
                $('#transferdiv').show();
                $('#bankdiv').show();
                $('#paymountdiv').show();
             }
             else
             {
                $('#transferdiv').hide();
                $('#bankdiv').hide();
                $('#paymountdiv').hide();
             }
        });

        $('#paytypeid').change(function() {
            
            var paymentMethod = $(this).val();
            var amount = $('#cost').val();
            var customerId = $('#mobno').val();
            if (paymentMethod === '3' ||paymentMethod === '6')
             {
                $('#transferdiv').show();
                $('#bankdiv').show();
                $('#paymountdiv').show();
             }
             else
             {
                $('#transferdiv').hide();
                $('#bankdiv').hide();
                $('#paymountdiv').hide();
             }
             
            if (paymentMethod === '2' && amount) {
                // Check balance for prepaid
                
                $.ajax({
                    url: '/check-balance',
                    method: 'GET',
                    data: { amount: amount, customer_id: customerId },
                    success: function(response) {
                        if (response.success) {
                            $('#error-message').hide();
                        } else {
                            $('#error-message').text('Insufficient balance.').show();
                        }
                    }
                });
            }

            if (paymentMethod === '4') {
                // Check if the customer is a cash customer
                $.ajax({
                    url: '/check-cash-customer',
                    method: 'GET',
                    data: { customer_id: customerId },
                    success: function(response) {
                        if (response.isCashCustomer) {
                            $('#error-message').hide();
                        } else {
                            $('#error-message').text('Customer is not a cash customer.').show();
                        }
                    }
                });
            }
        });

        
    </script>
@endsection
  