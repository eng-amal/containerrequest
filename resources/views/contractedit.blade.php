@extends('master')
@section('title',  __('contreq.pagename14'))
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
                    <h2>{{ __('contreq.pagename14') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('contractindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('contractupdate',$contract->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            @method('POST')
            <div class="w-25 p-3">
                        <strong>{{ __('contreq.contractdate') }}</strong>
                        <input class="form-control" dir="auto" type="date" value="{{ $contract->contractdate }}" name="contractdate" id="contractdate" class="form-control"  placeholder="{{ __('contreq.reqdate') }}">
                        @error('contractdate')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
               
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" id="mobileno" readonly value="{{ $contract->mobileno }}" name="mobileno" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobileno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="custname" value="{{ $contract->custname }}" name="custname" class="form-control" readonly placeholder="{{ __('contreq.custname') }}">
                        @error('custname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input type="text" name="whatno" value="{{ $contract->whatno }}" id="whatno" readonly class="form-control" placeholder="{{ __('contreq.whatno') }}">
                        @error('whatno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                   </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contsizeid') }}</strong>
                        <select id="contsizeid" class="form-select" name="contsizeid" >
                        <option value="">{{ __('contreq.contsizeid') }}</option>
                          @foreach ($containersizes as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->contsizeid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                         
                        </select>
                        
                        @error('contsizeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contnum') }}</strong>
                        <input type="text" name="contnum" id="contnum" value="{{ $contract->contnum }}" id="contnum" class="form-control" placeholder="{{ __('contreq.contnum') }}">
                        @error('contnum')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" class="form-select" name="cityid" >
                        <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($citys as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->cityid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                         
                        </select>
                        
                        @error('cityid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.street') }}</strong>
                        <select id="streetid" class="form-select" name="streetid">
                        <option value="">{{ __('contreq.street') }}</option>
                          @foreach ($streets as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->streetid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                        
                        </select>
                        
                        @error('streetid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.location_url') }}</strong>
                        <input type="text" name="location" value="{{ $contract->location }}" class="form-control" required placeholder="Paste Google Maps Location URL here">
                        @error('location')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.note') }}</strong>
                        <input type="text" name="note" value="{{ $contract->note }}" class="form-control" required placeholder="{{ __('contreq.note') }}">
                        @error('note')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.Commregister') }}</strong>
                        <input type="text" name="Commregister" value="{{ $contract->Commregister }}" class="form-control" required placeholder="{{ __('contreq.Commregister') }}">
                        @error('Commregister')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.address') }}</strong>
                        <input type="text" name="address" value="{{ $contract->address }}" class="form-control" required placeholder="{{ __('contreq.address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.Wastetype') }}</strong>
                        <select id="Wastetypeid" name="Wastetypeid" class="form-select" >
                        <option value="">{{ __('contreq.Wastetype') }}</option>
                          @foreach ($wastetypes as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->Wastetypeid  == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                       
                        </select>
                        
                        @error('Wastetypeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fromdate') }}</strong>
                        <input type="date" name="fromdate" id="fromdate" value="{{ $contract->fromdate }}" class="form-control" placeholder="fromdate">
                        @error('fromdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input type="date" name="todate" id="todate" value="{{ $contract->todate }}" class="form-control" placeholder="todate">
                        @error('todate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.emptycost') }}</strong>
                        <input type="text" name="emptycost" id="emptycost" value="{{ $contract->emptycost }}" class="form-control" required placeholder="{{ __('contreq.emptycost') }}">
                        @error('emptycost')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.emptynum') }}</strong>
                        <input type="text" name="emptynum" id="emptynum" value="{{ $contract->emptynum }}" class="form-control" required placeholder="{{ __('contreq.emptynum') }}">
                        @error('emptynum')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                      <div class="w-25 p-3">
                        <strong>{{ __('contreq.cost') }}</strong>
                        <input type="text" name="cost" value="{{ $contract->cost }}" id="cost"  class="form-control" placeholder="{{ __('contreq.cost') }}">
                        @error('cost')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytypeid" class="form-select" name="paytypeid" >
                        <option value="">{{ __('contreq.paytype') }}</option>
                          @foreach ($paytypes as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->paytypeid  == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                      
                        </select>
                        
                        @error('paytypeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3" id="bankdiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.payperoid') }}</strong>
                        <select id="payperoidid" class="form-select" name="payperoidid"  >
                        <option value="">{{ __('contreq.payperoid') }}</option>
                          @foreach ($payperoids as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->payperoidid   == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                      
                        </select>
                        
                        @error('payperoidid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="row flex">
                    <div class="w-25 p-3">
                    <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
         
        </form>
    </div>

   

  </main>
 </div>
  @endsection
  @section('scripts')
 
  <script>
$(document).ready(function(){
    $('#emptynum').on('change', function(){
            console.log('emptynum change event fired');
            var numOfEmpty = $(this).val();
            let fromDate = new Date(document.getElementById('fromdate').value);
            let toDate = new Date(document.getElementById('todate').value);
            let emptyCost = parseFloat(document.getElementById('emptycost').value);
            let contnum = parseInt(document.getElementById('contnum').value);
            // Check if all inputs are valid
            if (isNaN(emptyCost) ||isNaN(contnum) || isNaN(numOfEmpty) || isNaN(fromDate) || isNaN(toDate)) {
                alert('Please enter all values correctly.');
                return;
            }

            // Calculate the difference in months
            let monthDiff = (toDate.getFullYear() - fromDate.getFullYear()) * 12 + (toDate.getMonth() - fromDate.getMonth());

            // If the 'fromdate' is later than 'todate', alert the user
            if (monthDiff < 0) {
                alert('The "From Date" must be earlier than the "To Date".');
                return;
            }

            // Calculate the total cost
            let totalCost =contnum* emptyCost * numOfEmpty * monthDiff;

            // Display the result
            document.getElementById('cost').value = totalCost;
             
           
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

            if (payId === '2' ||payId === '4')
             {
                $('#bankdiv').show();
             }
             else
             {
                $('#bankdiv').hide();
             }
        });

        $('#paytypeid').change(function() {
            
            var paymentMethod = $(this).val();
            if (paymentMethod === '2' ||paymentMethod === '4')
             {
                
                $('#bankdiv').show();
                
             }
             else
             {
                
                $('#bankdiv').hide();
                
             }
        });

        
    </script>
@endsection
  