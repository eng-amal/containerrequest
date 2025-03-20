
@extends('master')
@section('title',  __('contreq.pagename28'))

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
                    <h2 class="text-color">{{ __('contreq.pagename28') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('additionindex', $addition->empid) }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('additionupdate',$addition->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            @method('POST')
            <input type="hidden" name="empid" value="{{ $addition->empid }}">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.additiontype') }}</strong>
                        <select id="additiontype" class="form-select" name="additiontype" value="{{ old('additiontype') }}" >
                        <option value="1" {{ $addition->additiontype == 1 ? 'selected' : '' }}>{{ __('contreq.additiontype1') }}</option>
                        <option value="2" {{ $addition->additiontype == 2 ? 'selected' : '' }}>{{ __('contreq.additiontype2') }}</option>

                        </select>
                        
                        @error('additiontype')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.ispercent') }}</strong>
                        <select id="ispercent" class="form-select" name="ispercent" value="{{ old('ispercent') }}" >
                        <option value="" {{ $addition->ispercent == '' ? 'selected' : '' }}>{{ __('contreq.ispercent') }}</option>
                        <option value="1" {{ $addition->ispercent == 1 ? 'selected' : '' }}>{{ __('contreq.ispercent1') }}</option>
                        <option value="2" {{ $addition->ispercent == 2 ? 'selected' : '' }}>{{ __('contreq.ispercent2') }}</option>

                        </select>
                        
                        @error('ispercent')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.isadd') }}</strong>
                        <select id="isadd" class="form-select" name="isadd" value="{{ old('isadd') }}" >
                        <option value="" {{ $addition->isadd == '' ? 'selected' : '' }}>{{ __('contreq.isadd') }}</option>
                        <option value="1" {{ $addition->isadd == 1 ? 'selected' : '' }}>{{ __('contreq.isadd1') }}</option>
                        <option value="2" {{ $addition->isadd == 2 ? 'selected' : '' }}>{{ __('contreq.isadd2') }}</option>

                        </select>
                        
                        @error('isadd')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.ispercent2') }}</strong>
                        <input type="text" requerid name="amount" id="amount" value="{{ $addition->amount }}" id="amount" class="form-control" placeholder="{{ __('contreq.ispercent2') }}">
                        @error('amount')
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