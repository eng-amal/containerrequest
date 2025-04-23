

@extends('master')
@section('title',  __('contreq.pagename3'))
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
    <!-- Starter Section Section -->
   

      <!-- Section Title -->
      

      <div >
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename3') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ url('/comind') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('compendingreq',$containerrequest->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            @method('POST')
           
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.reqdate') }}</strong>
                        <input type="date" name="reqdate" value="{{ $containerrequest->reqdate }}" class="form-control" readonly placeholder="requestdate">
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
                        <select id="contsizeid" name="contsizeid" class="form-control">
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
                        <select id="contid" name="contid" class="form-control">
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
                        <select id="cityid" name="cityid" class="form-control">
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
                        <select id="streetid" name="streetid" class="form-control">
                         <option value="">{{ __('contreq.street') }}</option>
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
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytypeid" name="paytypeid" class="form-control">
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
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.cost') }}</strong>
                        <input type="text" name="cost" value="{{ $containerrequest->cost }}" class="form-control" placeholder="{{ __('contreq.cost') }}">
                        @error('cost')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="driverpaydiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.driverpayamount') }}</strong>
                        <input type="text" name="driverpayamount" value="{{ $containerrequest->driverpayamount }}" class="form-control" placeholder="{{ __('contreq.driverpayamount') }}">
                        @error('driverpayamount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="remaindiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.remainamount') }}</strong>
                        <input type="text" name="remainamount" id="remainamount" value="{{ $containerrequest->remainamount }}" class="form-control" placeholder="{{ __('contreq.remainamount') }}">
                        @error('remainamount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($containerrequest->contimg)
                    <div class="w-50 p-3">
                       <label>Current Image:</label>
                       <img src="{{ asset('storage/' . $containerrequest->contimg) }}" alt="Container Image" width="200">
                    </div>
       
                    @endif
                    <div class="row flex">
                    <div class="w-25 p-3" id="bankdiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.bank') }}</strong>
                        <select id="bankid" name="bankid" class="form-control" >
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
                    <a href="{{ $containerrequest->contlocation }}" target="_blank">{{ __('contreq.location_url') }}</a>
                    </div>
                    <div class="w-25 p-3">
                    <a href="{{ $containerrequest->dcontlocation }}" target="_blank">{{ __('contreq.dlocation_url') }}</a>
                        
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.empid') }}</strong>
                        <select id="empid" name="empid" class="form-control">
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
                   </div>
                   
                 <div class="row flex">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fromdate') }}</strong>
                        <input readonly type="date" name="fromdate" value="{{ $containerrequest->fromdate }}" class="form-control" placeholder="fromdate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input readonly type="date" name="todate" value="{{ $containerrequest->todate }}" class="form-control" placeholder="todate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                </div>
                <div class="w-25 p-3" id="paytypediv" name="paytypediv" style="display: none;">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytype" class="form-select" name="paytype" value="{{ old('paytype') }}" >
                        <option value="1" {{ old('paytype') == 1 ? 'selected' : '' }}>{{ __('contreq.paytypeid1') }}</option>
                        <option value="2" {{ old('paytype') == 2 ? 'selected' : '' }}>{{ __('contreq.paytypeid2') }}</option>
                        
                        </select>
                        
                        @error('paytype')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                </div>
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.payamount') }}</strong>
                        <input type="text" required id="pamount" name="pamount" value="" class="form-control" placeholder="{{ __('contreq.payamount') }}">
                        @error('pamount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="pamounterror" class="alert alert-danger mt-1 mb-1" style="display:none;"></div>

                </div>
                <div class="w-25 p-3" id="bankdiv1" name="bankdiv1" style="display: none;">
                        <strong>{{ __('contreq.bank') }}</strong>
                        <select id="bank" class="form-select" name="bank" value="{{ old('bank') }}" class="form-control" >
                         <option value="" selected="selected">{{ __('contreq.bank') }}</option>
                      
                        </select>
                        
                        @error('bank')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
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
    document.addEventListener("DOMContentLoaded", function () {
        const completeRequest = document.getElementById("completeRequest");
        const suspendRequest = document.getElementById("suspendRequest");
        const suspensionReasonDiv = document.getElementById("suspensionReasonDiv");
        const pendingAmountDiv = document.getElementById("pendingAmountDiv");
        const pendingAmountAction = document.getElementById("pendingAmountAction");
        const additionalSuspensionReasonDiv = document.getElementById("additionalSuspensionReasonDiv");
        const chargeToDiv = document.getElementById("chargeToDiv");

        const paytype = document.getElementById("paytypeid").value;
        const remainingAmount = document.getElementById("remainamount").value;

        function checkConditions() {
            if (suspendRequest.checked) {
                suspensionReasonDiv.style.display = "block";
                pendingAmountDiv.style.display = "none";
                additionalSuspensionReasonDiv.style.display = "none";
                chargeToDiv.style.display = "none";
            } else if (completeRequest.checked) {
                suspensionReasonDiv.style.display = "none";
                if (paytype == 1 || paytype == 6|| paytype == 5) {
                    if (remainingAmount > 0) {
                        pendingAmountDiv.style.display = "block";
                    } else {
                        pendingAmountDiv.style.display = "none";
                    }
                }
            }
        }

        completeRequest.addEventListener("change", checkConditions);
        suspendRequest.addEventListener("change", checkConditions);

        pendingAmountAction.addEventListener("change", function () {
            if (this.value === "suspend") {
                additionalSuspensionReasonDiv.style.display = "block";
                chargeToDiv.style.display = "none";
            } else if (this.value === "complete") {
                additionalSuspensionReasonDiv.style.display = "none";
                chargeToDiv.style.display = "block";
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
 $(document).ready(function() {
            var payId = $('#paytypeid').val(); // Get the selected city ID

            if(payId === '5')
            {
                 $('#paytypediv').hide();
            }
            else{ 
                $('#paytypediv').hide();
            }
            if (payId === '3' ||payId === '6')
             {
                $('#transferdiv').show();
                $('#bankdiv').show();
                $('#paymountdiv').show();
                $('#paytypediv').show();
             }
             else
             {
                $('#transferdiv').hide();
                $('#bankdiv').hide();
                $('#paymountdiv').hide();
             }
             if (payId === '1' ||payId === '6')
             {
                $('#remaindiv').show();
                $('#driverpaydiv').show();
                
             }
             else
             {
                $('#remaindiv').hide();
                $('#driverpaydiv').hide();
               
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
             if (paymentMethod === '1' ||paymentMethod === '6')
             {
                $('#remaindiv').show();
                $('#driverpaydiv').show();
                
             }
             else
             {
                $('#remaindiv').hide();
                $('#driverpaydiv').hide();
               
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
    <script>
        $('#paytype').change(function() {
            
            var paymentMethod = $(this).val();
            if (paymentMethod === '2')
             {
                
                $('#bankdiv1').show();
                
                
             }
             else
             {
                
                $('#bankdiv1').hide();
                
             }
            });

        
</script>

<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-banks', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#bank').empty();
                    // Add a default option
                    $('#bank').append('<option value="">Select a bank</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, bank) {
                        $('#bank').append('<option value="' + bank.id + '">' + bank.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories: ', error);
                }
            });
        });
    </script>
<script>
    $(document).ready(function () {
        $('#pamount').on('input change', function () {
            const paytypeId = $('#paytypeid').val();
            const pamount = parseFloat($(this).val()) || 0;
            const cost = parseFloat($('#cost').val()) || 0;
            const remainAmount = parseFloat($('#remainamount').val()) || 0;

            let isValid = true;
            let errorMessage = '';

            if (paytypeId === '5') {
                if (pamount !== cost) {
                    isValid = false;
                    errorMessage = 'Amount must be equal to total cost.';
                }
            } else {
                if (pamount !== remainAmount) {
                    isValid = false;
                    errorMessage = 'Amount must be equal to remaining amount.';
                }
            }

            if (!isValid) {
                $('#pamounterror').text(errorMessage).show();
            } else {
                $('#pamounterror').hide();
            }
        });
    });
</script>


@endsection
  