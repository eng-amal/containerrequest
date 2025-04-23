
@extends('master')
@section('title',  __('contreq.pagename78'))

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
                    <h2 class="text-color">{{ __('contreq.pagename78') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('vendorindex') }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storevendor') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            
                    
                   
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" id="fullname" value="{{ old('fullname') }}" name="fullname" class="form-control" placeholder="{{ __('contreq.name') }}">
                        @error('fullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.email') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="email" value="{{ old('email') }}" name="email" class="form-control"  placeholder="{{ __('contreq.email') }}">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobno" value="{{ old('mobno') }}" id="mobno"  class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.address') }}</strong>
                        <input type="text" name="address" value="{{ old('address') }}" id="address"  class="form-control" placeholder="{{ __('contreq.address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.detail') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="detail" value="{{ old('detail') }}" name="detail" class="form-control"  placeholder="{{ __('contreq.detail') }}">
                        @error('detail')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   </div>
                   <div class="row flex">
                   <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" class="form-select" name="cityid" value="{{ old('cityid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.city') }}</option>
                         
                        </select>
                        
                        @error('cityid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.street') }}</strong>
                        <select id="streetid" class="form-select" name="streetid" value="{{ old('streetid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.street') }}</option>
                        
                        </select>
                        
                        @error('streetid')
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
    <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-cities', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#cityid').empty();
                    // Add a default option
                    $('#cityid').append('<option value="">Select city:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, city) {
                        $('#cityid').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities: ', error);
                }
            });
        });
    </script>
    <script>
$(document).ready(function(){
    // When the first dropdown changes
    $('#cityid').on('change', function(){
        var selectedValue = $(this).val(); // Get the selected value from first dropdown
        $('#streetid').append('<option value="">Select astreet1:</option>');
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
                    $('#streetid').append('<option value="">Select astreet3:</option>');
                    
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
        // Function to toggle the language between English and Arabic
        function toggleLanguage() {
            let curaddressLang = "{{ app()->getLocale() }}"; // Get curaddress language (English or Arabic)
            let newLang = curaddressLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

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
@endsection