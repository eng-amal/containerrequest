
@extends('master')
@section('title',  __('contreq.addcust'))

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
                    <h2 class="text-color">{{ __('contreq.addcust') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('customerindex') }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storecustomer') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf      
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input type="text" id="fullname" value="{{ old('fullname') }}" name="fullname" class="form-control" placeholder="{{ __('contreq.custname') }}">
                        @error('fullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="phone" value="{{ old('phone') }}" name="phone" class="form-control"  placeholder="{{ __('contreq.mobno') }}">
                        @error('phone')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   </div> 
                   <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="whatappno" value="{{ old('whatappno') }}" name="whatappno" class="form-control"  placeholder="{{ __('contreq.whatno') }}">
                        @error('whatappno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.searchno4') }}</strong>
                        <select id="status" class="form-select" name="status" value="{{ old('status') }}" onchange="toggleBalanceField()" >
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>{{ __('contreq.status1') }}</option>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>{{ __('contreq.status2') }}</option>
                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>{{ __('contreq.status3') }}</option>
                        <option value="3" {{ old('status') == 3 ? 'selected' : '' }}>{{ __('contreq.status4') }}</option>
                        </select>
                        
                        @error('status')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="baldiv" name="baldiv" style="display: none;">
                        <strong>{{ __('contreq.balance') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="balance" value="{{ old('balance') }}" name="balance" class="form-control"  placeholder="{{ __('contreq.balance') }}">
                        @error('balance')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   </div> 
                   <div class="w-50 p-3">
                        <strong>{{ __('contreq.account') }}</strong>
                        <select id="accountid" class="form-select" name="accountid" value="{{ old('accountid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.account') }}</option>
                         
                        </select>
                        
                        @error('accountid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 <div class="row flex">
                    <div class="w-25 p-3">
                    <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
            <!-- </div> -->
        </form>
    </div>
   


    </div><!-- /Starter Section Section -->

  </main>
</div>
@endsection
@section('scripts')
  <!-- Main JS File -->
  </div>
</div>
<script>
        // Function to toggle the language between English and Arabic
        function toggleLanguage() {
            let currentLang = "{{ app()->getLocale() }}"; // Get current language (English or Arabic)
            let newLang = currentLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

            // Add the new language to the form as a hidden input
            let form = document.getElementById('language-form');
            let langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.fullname = 'lang';
            langInput.value = newLang;
            form.appendChild(langInput);

            // Submit the form to reload the page with the new language
            form.submit();
        }
    </script>
    <script>
    function toggleBalanceField() {
        let status = document.getElementById("status").value;
        let balanceDiv = document.getElementById("baldiv");

        if (status == 1) {
            balanceDiv.style.display = "block";
        } else {
            balanceDiv.style.display = "none";
        }
    }

    // Run on page load in case status was pre-selected
    document.addEventListener("DOMContentLoaded", toggleBalanceField);
</script>
<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-accounts3', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#accountid').empty();
                    // Add a default option
                    $('#accountid').append('<option value="">Select a account</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, account) {
                        $('#accountid').append('<option value="' + account.id + '">' + account.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching accounts: ', error);
                }
            });
        });
    </script>

@endsection