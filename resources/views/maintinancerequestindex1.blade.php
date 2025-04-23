@extends('master')
@section('title',  __('contreq.pagename93'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename93') }}</h2>
      </div> 
      @if ($message = Session::get('error'))
           <div class="alert alert-danger">
             <p>{{ $message }}</p>
           </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.maindate') }}</th>
                    <th>{{ __('contreq.reqname') }}</th>
                    <th>{{ __('contreq.sizename') }}</th>
                    <th>{{ __('contreq.contname') }}</th>
                    <th>{{ __('contreq.carno') }}</th>
                    <th>{{ __('contreq.drivernote') }}</th>
                    <th>{{ __('contreq.processdate') }}</th>
                    <th>{{ __('contreq.pfullname') }}</th>
                    <th>{{ __('contreq.processnote') }}</th>
                    <th>{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maintinancerequests as $maintinancerequest)
                    <tr>
                        <td>{{ $maintinancerequest->id }}</td>
                        <td>{{ $maintinancerequest->maindate }}</td>
                        <td>{{ $maintinancerequest->fullname}}</td>
                        <td>{{ $maintinancerequest->sizename}}</td>
                        <td>{{ $maintinancerequest->contname}}</td>
                        <td>{{ $maintinancerequest->no}}</td>
                        <td>{{ $maintinancerequest->drivernote}}</td>
                        <td>{{ $maintinancerequest->processdate}}</td>
                        <td>{{ $maintinancerequest->pfullname}}</td>
                        <td>{{ $maintinancerequest->processnote}}</td>
                        
                        <td>
                        <a class="btn" title="close" href="{{ route('maintinancerequestclos',$maintinancerequest->id) }}">
                                <img src="{{ asset('images/process.JPG') }}" alt="update" width="30" height="30"> 
                                </a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
      
    </div>
    </section><!-- /Starter Section Section -->

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