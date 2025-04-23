@extends('master')
@section('title',  __('contreq.pagename95'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename95') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('maintinancerequestindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('maintinancerequestupdate',$maintinancerequest->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
        @csrf
        @method('POST')
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.maindate') }}</strong>
                        <input type="date" name="maindate" readonly value="{{ $maintinancerequest->maindate }}" class="form-control">
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" name="fullname" readonly value="{{ $maintinancerequest->fullname }}" class="form-control">
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.carno') }}</strong>
                        <input type="text" name="no" readonly value="{{ $maintinancerequest->no }}" class="form-control">
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contname') }}</strong>
                        <input type="text" name="contname" readonly value="{{ $maintinancerequest->contname }}" class="form-control">
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.sizename') }}</strong>
                        <input type="text" name="sizename" readonly value="{{ $maintinancerequest->sizename }}" class="form-control">
                    </div>
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.drivernote') }}</strong>
                        <input type="text" name="drivernote" readonly value="{{ $maintinancerequest->drivernote }}" class="form-control">
                    </div>
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.processnote') }}</strong>
                        <input type="text" name="processnote" id="processnote" value="{{ old('processnote') }}" class="form-control" placeholder="processnote">
                        @error('processnote')
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
  