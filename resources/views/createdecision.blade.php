
@extends('master')
@section('title',  __('contreq.pagename30'))

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
                    <h2 class="text-color">{{ __('contreq.pagename30') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('decisionindex', $employee->id) }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storedecision') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input type="hidden" name="empid" value="{{ $employee->id }}">
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.decisiontype') }}</strong>
                        <select id="decisiontype" class="form-select" name="decisiontype" value="{{ old('decisiontype') }}" >
                        <option value="1" {{ old('decisiontype') == 1 ? 'selected' : '' }}>{{ __('contreq.decisiontype1') }}</option>
                        <option value="2" {{ old('decisiontype') == 2 ? 'selected' : '' }}>{{ __('contreq.decisiontype2') }}</option>
                        <option value="3" {{ old('decisiontype') == 3 ? 'selected' : '' }}>{{ __('contreq.decisiontype3') }}</option>
                        </select>
                        
                        @error('decisiontype')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.decisiondate') }}</strong>
                        <input type="date" requerid name="decisiondate" id="decisiondate" value="{{ old('decisiondate') }}" id="decisiondate" class="form-control" placeholder="{{ __('contreq.peroid') }}">
                        @error('decisiondate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.decisionimg') }}</strong>
                        <input type="file" name="decisionimg" value="{{ old('decisionimg',0) }}" class="form-control" placeholder="{{ __('contreq.decisionimg') }}">
                        @error('decisionimg')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.ispercent2') }}</strong>
                        <input type="text" requerid name="amount" id="amount" value="{{ old('amount') }}" id="amount" class="form-control" placeholder="{{ __('contreq.ispercent2') }}">
                        @error('amount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.peroid') }}</strong>
                        <input type="text" requerid name="peroid" id="peroid" value="{{ old('peroid') }}" id="peroid" class="form-control" placeholder="{{ __('contreq.peroid') }}">
                        @error('peroid')
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
document.addEventListener("DOMContentLoaded", function() {
    let decisionType = document.getElementById("decisiontype");
    let amountField = document.getElementById("amount").closest('.w-25'); 
    let periodField = document.getElementById("peroid").closest('.w-25'); 

    function toggleFields() {
        if (decisionType.value == "3") {
            amountField.style.display = "block"; 
            periodField.style.display = "block"; 
        } else {
            amountField.style.display = "none"; 
            periodField.style.display = "none"; 
        }
    }

    decisionType.addEventListener("change", toggleFields);
    toggleFields(); // Run on page load in case of old value
});
</script>
@endsection