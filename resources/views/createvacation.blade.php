
@extends('master')
@section('title',  __('contreq.pagename36'))

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
                    <h2 class="text-color">{{ __('contreq.pagename36') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('vacationindex', $employee->id) }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storevacation') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input type="hidden" name="empid" value="{{ $employee->id }}">
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.vactype') }}</strong>
                        <select id="vactype" class="form-select" name="vactype" value="{{ old('vactype') }}" >
                        <option value="1" {{ old('vactype') == 1 ? 'selected' : '' }}>{{ __('contreq.vactype1') }}</option>
                        <option value="2" {{ old('vactype') == 2 ? 'selected' : '' }}>{{ __('contreq.vactype2') }}</option>
                        <option value="3" {{ old('vactype') == 3 ? 'selected' : '' }}>{{ __('contreq.vactype3') }}</option>
                        </select>
                        
                        @error('vactype')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.vacdate') }}</strong>
                        <input type="date" requerid name="vacdate" id="vacdate" value="{{ old('vacdate') }}" id="vacdate" class="form-control" placeholder="{{ __('contreq.peroid') }}">
                        @error('vacdate')
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
@endsection