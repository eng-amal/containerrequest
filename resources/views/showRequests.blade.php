@extends('master')
@section('title',  __('contreq.pagename4'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
 <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename4') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
<!-- Search Form -->
<form method="GET" action="{{ route('showRequests') }}" class="form-group p-3 flex row">
        <div class="w-25 p-3">
            <label for="search_mobile">{{ __('contreq.searchno') }}</label>
            <input type="text" id="search_mobile" name="search_mobile" value="{{ request('search_mobile') }}">
        </div>

        <div class="w-25 p-3">
            <label for="search_container_no">{{ __('contreq.searchno1') }}</label>
            <input type="text" id="search_container_no" name="search_container_no" value="{{ request('search_container_no') }}">
        </div>
        <div class="w-25 p-3">
           
        <button  class="btn btn-outline-primary" type="submit">{{ __('contreq.search') }}</button></div>
</form>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.reqdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.mobno') }}</th>
                    <th>{{ __('contreq.contid') }}</th>
                    <th>{{ __('contreq.todate') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($containerrequests as $containerrequest)
                    <tr class="{{ \Carbon\Carbon::parse($containerrequest->todate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($containerrequest->todate)->isToday() ? 'future-request' : '' }}">
                        <td>{{ $containerrequest->id }}</td>
                        <td>{{ $containerrequest->reqdate }}</td>
                        <td>{{ $containerrequest->custname }}</td>
                        <td>{{ $containerrequest->mobno }}</td>
                        <td>{{ $containerrequest->conno }}</td>
                        <td>{{ $containerrequest->todate }}</td>
                        <td>
                        <a class="btn" href="{{ route('fillreq',$containerrequest->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="update" width="30" height="30"> 
                                </a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $containerrequests->links() !!}
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