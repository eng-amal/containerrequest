@extends('master')
@section('title',  __('contreq.pagename10'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename10') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.reqdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.mobno') }}</th> 
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($liftreqs as $liftreq)
                    <tr>
                        <td >{{ $liftreq->id }}</td>
                        <td >{{ $liftreq->reqdate }}</td>
                        <td >{{ $liftreq->custname }}</td>
                        <td>{{ $liftreq->mobno }}</td>
                        <td>
                    <!-- Update Button -->
                    <a class="btn" title="view" href="{{ route('compemptyreq', $liftreq->id) }}"> <img src="{{ asset('images/view.JPG') }}" alt="view" width="30" height="30"> 
                   </a>
                   
                </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
       
    </div>
    

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