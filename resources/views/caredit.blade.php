@extends('master')
@section('title',  __('contreq.pagename70'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename70') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('carindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('carupdate',$car->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
        @csrf
        @method('POST')
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.model') }}</strong>
                        <input type="text" name="model" value="{{ $car->model }}" class="form-control"  placeholder="{{ __('contreq.model') }}">
                        @error('model')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.carno') }}</strong>
                        <input type="text" name="no" readonly value="{{ $car->no }}" class="form-control" placeholder="{{ __('contreq.carno') }}">
                        @error('no')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fullname') }}</strong>
                        <select id="empid" name="empid" class="form-select">
                         <option value="">{{ __('contreq.fullname') }}</option>
                          @foreach ($employees as $cont)
                          <option value="{{ $cont->id }}" {{ $car->empid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->fullname }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('empid')
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
  