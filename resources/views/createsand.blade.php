
@extends('master')
@section('title',  __('contreq.pagename44'))

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
                    <h2 class="text-color">{{ __('contreq.pagename44') }}</h2>
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
        <form action="{{ route('storesand') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.sanddate') }}</strong>
                        <input type="date" required name="sanddate" id="sanddate" value="{{ old('sanddate') }}" id="sanddate" class="form-control" placeholder="{{ __('contreq.sanddate') }}">
                        @error('sanddate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.type') }}</strong>
                        <select id="type" class="form-select" name="type" value="{{ old('type') }}" >
                        <option value="" {{ old('type') == '' ? 'selected' : '' }}>{{ __('contreq.type') }}</option>
                        <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>{{ __('contreq.sandtype1') }}</option>
                        <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>{{ __('contreq.sandtype2') }}</option>
                        
                        </select>
                        
                        @error('type')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" >
                        <strong>{{ __('contreq.saccountid') }}</strong>
                        <select id="saccountid" name="saccountid" class="form-select" value="{{ old('saccountid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.saccountid') }}</option>
                       
                        </select>
                        
                        @error('saccountid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" >
                        <strong>{{ __('contreq.saccountid') }}</strong>
                        <select id="raccountid" name="raccountid" class="form-select" value="{{ old('raccountid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.saccountid') }}</option>
                       
                        </select>
                        
                        @error('raccountid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.ispercent2') }}</strong>
                        <input type="text" required name="amount" id="amount" value="{{ old('amount') }}" id="amount" class="form-control" placeholder="{{ __('contreq.ispercent2') }}">
                        @error('amount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.reason') }}</strong>
                        <input type="text"  name="reason" id="reason" value="{{ old('reason') }}" id="reason" class="form-control" placeholder="{{ __('contreq.reason') }}">
                        @error('reason')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                   <div class="row flex">
                    <div class="w-25 p-3">
                    <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div>
            <!-- </div> -->
            <div class="w-25 p-3">
              <button type="button" class="btn btn-outline-secondary" id="generate-pdf">{{ __('contreq.repname') }}</button>
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
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-accounts', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#saccountid').empty();
                    $('#raccountid').empty();
                    // Add a default option
                    $('#saccountid').append('<option value="">Select account:</option>');
                    $('#raccountid').append('<option value="">Select account:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, account) {
                        $('#saccountid').append('<option value="' + account.id + '">' + account.name + '</option>');
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
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const type = document.getElementById('type').value;
        const saccountid = document.getElementById('saccountid').value;
        const amount = document.getElementById('amount').value;
        if (!type || !saccountid) {
            alert('يرجى اختيار نوع العملية والحساب أولاً');
            return;
        }

        const today = new Date().toISOString().split('T')[0];

        // Construct the URL to your report generation route
        const url = `/generate-report?type=${type}&amount=${amount}&saccountid=${saccountid}&date=${today}`;

        // Open in a new tab
        window.open(url, '_blank');
    });
</script>

@endsection