@extends('master')
@section('title',  __('contreq.pagename79'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename79') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('vendorindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('vendorupdate',$vendor->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
        @csrf
        @method('POST')
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" name="fullname" value="{{ $vendor->fullname }}" class="form-control" readonly placeholder="requestdate">
                        @error('fullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobno"  value="{{ $vendor->mobno }}" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.email') }}</strong>
                        <input type="text" name="email"  value="{{ $vendor->email }}" class="form-control" placeholder="{{ __('contreq.email') }}">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" name="cityid" class="form-select">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($citys as $city)
                          <option value="{{ $city->id }}" {{ $vendor->cityid == $city->id ? 'selected' : '' }}>
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
                          <option value="{{ $street->id }}" {{ $vendor->streetid == $street->id ? 'selected' : '' }}>
                        {{ $street->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('streetid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                 <div class="w-25 p-3">
                        <strong>{{ __('contreq.address') }}</strong>
                        <input type="text" name="address" value="{{ $vendor->address }}" class="form-control" placeholder="{{ __('contreq.address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.detail') }}</strong>
                        <input type="text" name="detail" value="{{ $vendor->detail }}" class="form-control" placeholder="{{ __('contreq.detail') }}">
                        @error('detail')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>                
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.account') }}</strong>
                        <select id="accountid" name="accountid" class="form-select">
                         <option value="">{{ __('contreq.account') }}</option>
                          @foreach ($accounts as $account)
                          <option value="{{ $account->id }}" {{ $vendor->accountid == $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('accountid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    
                    
                
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.nationality') }}</strong>
                        <select id="nationality" name="nationality" class="form-select">
                         <option value="">{{ __('contreq.nationality') }}</option>
                          @foreach ($nationalitys as $nationality)
                          <option value="{{ $nationality->id }}" {{ $vendor->nationality == $nationality->id ? 'selected' : '' }}>
                        {{ $nationality->name }}
                          </option>
                         @endforeach
                        </select>
                        @error('nationality')
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

@endsection
  