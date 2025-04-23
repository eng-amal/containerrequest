@extends('master')
@section('title',  __('contreq.pagename45'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename45') }}</h2>
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
                    <th>{{ __('contreq.name') }}</th>
                    <th>{{ __('contreq.enname') }}</th>
                    <th>{{ __('contreq.code') }}</th>
                    <th>{{ __('contreq.type') }}</th>
                    <th>{{ __('contreq.parent') }}</th>
                    <th>{{ __('contreq.inamount') }}</th>
                    <th>{{ __('contreq.outamount') }}</th>
                    <th>{{ __('contreq.balance') }}</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->enname }}</td>
                        <td>{{ $account->code }}</td>
                        <td>{{ $account->type_label }}</td>
                        <td>{{ $account->parent_name ?? '-' }}</td>
                        <td>{{ $account->inamount }}</td>
                        <td>{{ $account->outamount }}</td>
                        <td>{{ $account->balance }}</td>
                        
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