
@extends('master')
@section('title',  __('contreq.pagename42'))

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
                    <h2 class="text-color">{{ __('contreq.pagename42') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('accountindex')}}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storeaccount') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" required name="name" id="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="{{ __('contreq.name') }}">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.enname') }}</strong>
                        <input type="text" required name="enname" id="enname" value="{{ old('enname') }}" id="enname" class="form-control" placeholder="{{ __('contreq.enname') }}">
                        @error('enname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.type') }}</strong>
                        <select id="type" class="form-select" name="type" value="{{ old('type') }}" >
                        <option value="" {{ old('type') == '' ? 'selected' : '' }}>{{ __('contreq.type') }}</option>
                        <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>{{ __('contreq.type1') }}</option>
                        <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>{{ __('contreq.type2') }}</option>
                        <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>{{ __('contreq.type3') }}</option>
                        </select>
                        
                        @error('type')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="parentid-wrapper" style="display: none;">
                        <strong>{{ __('contreq.parent') }}</strong>
                        <select id="parentid" name="parentid" class="form-select" value="{{ old('parentid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.parent') }}</option>
                       
                        </select>
                        
                        @error('parentid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.code') }}</strong>
                        <input type="text"  name="code" id="code" readonly value="{{ old('code') }}"  class="form-control" placeholder="{{ __('contreq.code') }}">
                        @error('code')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div> 
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.balance') }}</strong>
                        <input type="text" required name="balance" id="balance" value="{{ old('balance') }}" id="balance" class="form-control" placeholder="{{ __('contreq.balance') }}">
                        @error('balance')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
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

// Fetch next code dynamically
function fetchNextAccountCode() {
    var selectedType = $('#type').val();
    var selectedParentId = $('#parentid').val();

    // Only proceed if type is selected
    if (selectedType !== '') {
        $.ajax({
            url: '{{ route("get-next-account-code") }}',
            method: 'GET',
            data: {
                type: selectedType,
                parentid: selectedParentId
            },
            success: function(response) {
                if (response.next_code) {
                    $('#code').val(response.next_code); // Set code value
                } else {
                    $('#code').val(''); // Clear if no code found
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching next code:', error);
            }
        });
    } else {
        $('#code').val(''); // Clear code if type is not selected
    }
}

// Fetch accounts for parentid dropdown and trigger code generation
function handleParentFieldAndFetchAccounts() {
    var selectedType = $('#type').val();

    let apiUrl = '';
    if (selectedType == '2') {
        apiUrl = '/get-accounts2';
    } else if (selectedType == '3') {
        apiUrl = '/get-accounts3';
    }

    // If type is 2 or 3, show parent dropdown and load options
    if (apiUrl !== '') {
        $('#parentid-wrapper').show();

        $.ajax({
            url: apiUrl,
            method: 'GET',
            data: { type: selectedType },
            success: function(response) {
                $('#parentid').empty();
                $('#parentid').append('<option value="">' + '{{ __('contreq.parent') }}' + '</option>');
                $.each(response, function(index, account) {
                    $('#parentid').append('<option value="' + account.id + '">' + account.name + '</option>');
                });

                // Retain old parentid if available
                var oldParentId = '{{ old('parentid') }}';
                if (oldParentId) {
                    $('#parentid').val(oldParentId);
                }

                // Trigger code fetch after loading parents
                fetchNextAccountCode();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching parent accounts:', error);
            }
        });

    } else {
        // Hide parent field for type 1
        $('#parentid-wrapper').hide();
        $('#parentid').empty().append('<option value="">' + '{{ __('contreq.parent') }}' + '</option>');

        // Trigger code fetch for type 1
        fetchNextAccountCode();
    }
}

// On page load
handleParentFieldAndFetchAccounts();

// Trigger when type is changed
$('#type').on('change', function() {
    handleParentFieldAndFetchAccounts();
});

// Trigger when parentid is changed (for type 2 & 3)
$('#parentid').on('change', function() {
    fetchNextAccountCode();
});
});
</script>
@endsection