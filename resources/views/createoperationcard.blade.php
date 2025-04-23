
@extends('master')
@section('title',  __('contreq.pagename73'))

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
                    <h2 class="text-color">{{ __('contreq.pagename73') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('operationcardindex', $car->id) }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storeoperationcard') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input type="hidden" name="carid" value="{{ $car->id }}">
                    
            <div class="w-25 p-3">
                        <strong>{{ __('contreq.fullname') }}</strong>
                        <input type="text" requerid name="name" id="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="{{ __('contreq.fullname') }}">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.idnumber') }}</strong>
                        <input type="text" requerid name="idnumber" id="idnumber" value="{{ old('idnumber') }}"  class="form-control" placeholder="{{ __('contreq.idnumber') }}">
                        @error('idnumber')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.cardno') }}</strong>
                        <input type="text" requerid name="cardno" id="cardno" value="{{ old('cardno') }}"  class="form-control" placeholder="{{ __('contreq.cardno') }}">
                        @error('cardno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.maker') }}</strong>
                        <input type="text" requerid name="maker" id="maker" value="{{ old('maker') }}"  class="form-control" placeholder="{{ __('contreq.maker') }}">
                        @error('maker')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fromdate1') }}</strong>
                        <input type="date" requerid name="fromdate" id="fromdate" value="{{ old('fromdate') }}" id="fromdate" class="form-control" placeholder="{{ __('contreq.fromdate') }}">
                        @error('fromdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input type="date" requerid name="todate" id="todate" value="{{ old('todate') }}" id="todate" class="form-control" placeholder="{{ __('contreq.fromdate') }}">
                        @error('todate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.model') }}</strong>
                        <input type="text" requerid name="model" id="model" value="{{ old('model') }}"  class="form-control" placeholder="{{ __('contreq.model') }}">
                        @error('model')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.patenumber') }}</strong>
                        <input type="text" requerid name="patenumber" id="patenumber" value="{{ old('patenumber') }}"  class="form-control" placeholder="{{ __('contreq.patenumber') }}">
                        @error('patenumber')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.color') }}</strong>
                        <input type="text" requerid name="color" id="color" value="{{ old('color') }}"  class="form-control" placeholder="{{ __('contreq.color') }}">
                        @error('color')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.modelyear') }}</strong>
                        <input type="text" requerid name="modelyear" id="modelyear" value="{{ old('modelyear') }}"  class="form-control" placeholder="{{ __('contreq.modelyear') }}">
                        @error('modelyear')
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