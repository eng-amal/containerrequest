
@extends('master')
@section('title',  __('contreq.master53'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
    <!-- Starter Section Section -->
    <div >

      <!-- Section Title -->
      

      <div >
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2 class="text-color">{{ __('contreq.master53') }}</h2>
                </div>
                
            </div>
        </div>
        @if ($message = Session::get('error'))
           <div class="alert alert-danger">
             <p>{{ $message }}</p>
           </div>
        @endif
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('storecustpayment') }}" method="POST" encpaytype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            
                     <div class="w-25 p-3" >
                        <strong>{{ __('contreq.name') }}</strong>
                        <select id="custid" name="custid" class="form-select" value="{{ old('custid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.name') }}</option>
                       
                        </select>
                        
                        @error('custid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.amount') }}</strong>
                        <input paytype="text" required name="amount" id="amount" value="{{ old('amount') }}" id="amount" class="form-control" placeholder="{{ __('contreq.amount') }}">
                        @error('amount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytype" class="form-select" name="paytype" value="{{ old('paytype') }}" >
                        <option value="1" {{ old('paytype') == 1 ? 'selected' : '' }}>{{ __('contreq.paytypeid1') }}</option>
                        <option value="2" {{ old('paytype') == 2 ? 'selected' : '' }}>{{ __('contreq.paytypeid2') }}</option>
                        
                        </select>
                        
                        @error('paytype')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="bankdiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.bank') }}</strong>
                        <select id="bankid" class="form-select" name="bankid" value="{{ old('bankid') }}" class="form-control" >
                         <option value="" selected="selected">{{ __('contreq.bank') }}</option>
                      
                        </select>
                        
                        @error('bankid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3" id="transferdiv" name="transferdiv" style="display: none;">
                        <strong>{{ __('contreq.transferno') }}</strong>
                        <input type="file" name="transferno" value="{{ old('transferno',0) }}" class="form-control" placeholder="{{ __('contreq.transferno') }}">
                        @error('transferno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    
                   <div class="row flex">
                    <div class="w-25 p-3">
                    <button paytype="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div>
            <!-- </div> -->
            <div class="w-25 p-3">
              <button paytype="button" class="btn btn-outline-secondary" id="generate-pdf">{{ __('contreq.repname') }}</button>
            </div></div>
        </form>
    </div>
    </div><!-- /Starter Section Section -->

  </main>
</div>
@endsection
@section('scripts')
  <!-- Main JS File -->
  
<script>
        // Function to toggle the language between English and Arabic
        function toggleLanguage() {
            let currentLang = "{{ app()->getLocale() }}"; // Get current language (English or Arabic)
            let newLang = currentLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

            // Add the new language to the form as a hidden input
            let form = document.getElementById('language-form');
            let langInput = document.createElement('input');
            langInput.paytype = 'hidden';
            langInput.name = 'lang';
            langInput.value = newLang;
            form.appendChild(langInput);

            // Submit the form to reload the page with the new language
            form.submit();
        }
    </script>
    <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-accounts', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#custid').empty();
                    $('#raccountid').empty();
                    // Add a default option
                    $('#custid').append('<option value="">Select account:</option>');
                    $('#raccountid').append('<option value="">Select account:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, account) {
                        $('#custid').append('<option value="' + account.id + '">' + account.name + '</option>');
                        $('#raccountid').append('<option value="' + account.id + '">' + account.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching accounts: ', error);
                }
            });
        });
    </script>
    <script>
        $('#paytype').change(function() {
            
            var paymentMethod = $(this).val();
            if (paymentMethod === '2')
             {
                $('#transferdiv').show();
                $('#bankdiv').show();
                
                
             }
             else
             {
                $('#transferdiv').hide();
                $('#bankdiv').hide();
                
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
                    $('#bankid').empty();
                    // Add a default option
                    $('#bankid').append('<option value="">Select a bank</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, bank) {
                        $('#bankid').append('<option value="' + bank.id + '">' + bank.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories: ', error);
                }
            });
        });
    </script>

     <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-customers', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#custid').empty();
                    // Add a default option
                    $('#custid').append('<option value="">Select employee:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, cust) {
                        $('#custid').append('<option value="' + cust.id + '">' + cust.fullname + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching employees: ', error);
                }
            });
        });
    </script>
    <script>
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const paytype = document.getElementById('paytype').value;
        const custid = document.getElementById('custid').value;
        const amount = document.getElementById('amount').value;
        if (!paytype || !custid) {
            alert('يرجى اختيار نوع العملية والحساب أولاً');
            return;
        }

        const today = new Date().toISOString().split('T')[0];

        // Construct the URL to your report generation route
        const url = `/generatereq-report?paytype=${paytype}&amount=${amount}&custid=${custid}&date=${today}`;

        // Open in a new tab
        window.open(url, '_blank');
    });
</script>

@endsection