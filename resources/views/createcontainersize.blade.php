
@extends('master')
@section('title',  __('contreq.pagename55'))

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
                    <h2 class="text-color">{{ __('contreq.pagename55') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('containersizeindex') }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storecontainersize') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf      
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" id="name" value="{{ old('name') }}" name="name" class="form-control" placeholder="{{ __('contreq.name') }}">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.enname') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="enname" value="{{ old('enname') }}" name="enname" class="form-control"  placeholder="{{ __('contreq.enname') }}">
                        @error('enname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
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
    function toggleBalanceField() {
        let status = document.getElementById("status").value;
        let balanceDiv = document.getElementById("baldiv");

        if (status == 1) {
            balanceDiv.style.display = "block";
        } else {
            balanceDiv.style.display = "none";
        }
    }

    // Run on page load in case status was pre-selected
    document.addEventListener("DOMContentLoaded", toggleBalanceField);
</script>
@endsection