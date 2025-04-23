@extends('master')
@section('title',  __('contreq.pagename1'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename1') }}</h2>
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

        <!-- Search Form -->
<form method="GET" action="{{ route('containerrequests.index') }}" class="form-group p-3 flex row">
     <div class="row flex">
        <div class="w-25 p-3">
            <label for="search_mobile">{{ __('contreq.searchno') }}</label>
            <input type="text" id="search_mobile" name="search_mobile" value="{{ request('search_mobile') }}">
        </div>

        <div class="w-25 p-3">
            <label for="search_container_no">{{ __('contreq.searchno1') }}</label>
            <input type="text" id="search_container_no" name="search_container_no" value="{{ request('search_container_no') }}">
        </div>
        <div class="w-25 p-3">
            <label for="search_tdate">{{ __('contreq.searchno4') }}</label>
            <select id="search_status" class="form-select" name="search_status">
                         <option value="">{{ __('contreq.stat1') }}</option>
                         <option value="1" {{ old('search_status') == 1 ? 'selected' : '' }}>{{ __('contreq.stat2') }}</option>
                        <option value="2" {{ old('search_status') == 2 ? 'selected' : '' }}>{{ __('contreq.stat3') }}</option>
                        <option value="3" {{ old('search_status') == 3 ? 'selected' : '' }}>{{ __('contreq.stat4') }}</option>
                        <option value="5" {{ old('search_status') == 5 ? 'selected' : '' }}>{{ __('contreq.stat5') }}</option>
                        <option value="14" {{ old('search_status') == 14 ? 'selected' : '' }}>{{ __('contreq.stat6') }}</option>
                        <option value="11" {{ old('search_status') == 11 ? 'selected' : '' }}>{{ __('contreq.stat7') }}</option>
                        <option value="12" {{ old('search_status') == 12 ? 'selected' : '' }}>{{ __('contreq.stat8') }}</option>
                        <option value="13" {{ old('search_status') == 13 ? 'selected' : '' }}>{{ __('contreq.stat9') }}</option>
                        <option value="4" {{ old('search_status') == 4 ? 'selected' : '' }}>{{ __('contreq.stat10') }}</option>
            </select>
        </div>
    </div>
        <div class="w-25 p-3">
            <label for="search_fdate">{{ __('contreq.searchno2') }}</label>
            <input type="date" id="search_fdate" name="search_fdate" value="{{ request('search_fdate') }}">
        </div>
        
        <div class="w-25 p-3">
            <label for="search_tdate">{{ __('contreq.searchno3') }}</label>
            <input type="date" id="search_tdate" name="search_tdate" value="{{ request('search_tdate') }}">
        </div>
       

        <div class="w-25 p-3">
           
        <button  class="btn btn-outline-primary" type="submit">{{ __('contreq.search') }}</button></div>
</form>
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.reqdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.mobno') }}</th>
                    <th>{{ __('contreq.stat1') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($containerrequests as $containerrequest)
                    <tr>
                        <td>{{ $containerrequest->id }}</td>
                        <td>{{ $containerrequest->reqdate }}</td>
                        <td>{{ $containerrequest->custname }}</td>
                        <td>{{ $containerrequest->mobno }}</td>
                        <td ><select id="status" class="form-select" name="status">
                        <option value="" selected="selected">{{ __('contreq.stat1') }}</option>
                         <option value="1" {{ $containerrequest->status == 1 ? 'selected' : '' }}>{{ __('contreq.stat2') }}</option>
                        <option value="2" {{ $containerrequest->status == 2 ? 'selected' : '' }}>{{ __('contreq.stat3') }}</option>
                        <option value="3" {{ $containerrequest->status == 3 ? 'selected' : '' }}>{{ __('contreq.stat4') }}</option>
                        <option value="5" {{ $containerrequest->status == 5 ? 'selected' : '' }}>{{ __('contreq.stat5') }}</option>
                        <option value="14" {{ $containerrequest->status == 14 ? 'selected' : '' }}>{{ __('contreq.stat6') }}</option>
                        <option value="11" {{ $containerrequest->status == 11 ? 'selected' : '' }}>{{ __('contreq.stat7') }}</option>
                        <option value="12" {{ $containerrequest->status == 12 ? 'selected' : '' }}>{{ __('contreq.stat8') }}</option>
                        <option value="13" {{ $containerrequest->status == 13 ? 'selected' : '' }}>{{ __('contreq.stat9') }}</option>
                        <option value="4" {{ $containerrequest->status == 4 ? 'selected' : '' }}>{{ __('contreq.stat10') }}</option>
                        </select>
                        </td>
                        <td>
                        @if($containerrequest->status == 1 || $containerrequest->status == 2)
                            <form action="{{ route('containerrequests.cancel',$containerrequest->id) }}" method="Post">
                                <a class="btn" title="edit" href="{{ route('containerrequests.edit',$containerrequest->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="30" height="30"> 
                                </a>
                                <!-- Send Button -->
                               <a class="btn" title="send to driver" href="{{ url('/containerrequests/send/' . $containerrequest->id) }}">
                               <img src="{{ asset('images/send.JPG') }}" alt="send to driver" width="30" height="30">
                              </a>
                              
                                @csrf
                                @method('POST')
                             <button type="submit" class="btn">
                             <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="30" height="30"> 
                             </button>
                            </form>
                            @endif
                            @if($containerrequest->status == 3)
                            <form action="{{ route('containerrequests.delete', $containerrequest->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn"> <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="30" height="30"></button>
                            </form>
                            @endif
                            @if($containerrequest->status == 14)
                            <a class="btn" title="complate" href="{{ route('comppending',$containerrequest->id) }}">
                                <img src="{{ asset('images/process.JPG') }}" alt="update" width="30" height="30"> 
                            </a>
                            
                            @endif
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