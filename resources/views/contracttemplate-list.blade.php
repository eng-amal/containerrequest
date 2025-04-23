@extends('master')
@section('title',  __('contreq.pagename86'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<h2>{{ __('contreq.pagename86') }}</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('contreq.Evaname') }}</th>
            <th>{{ __('contreq.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contracttemplates as $contracttemplate)
            <tr>
                <td>{{ $contracttemplate->name }}</td>
                <td>
                    <a href="{{ route('contracttemplatedetails', [$contracttemplate->id]) }}" class="btn btn-primary">
                        {{ __('contreq.startcontracttemplate') }}
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
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