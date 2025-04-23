@extends('master')
@section('title',  __('contreq.pagename89'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename89') }}</h2>
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
        <a class="btn" href="{{ route('createcomplamint') }}">
                                <img src="{{ asset('images/add.JPG') }}" alt="create" width="30" height="30"> 
                                </a>
        <form method="GET" action="{{ route('complamintindex') }}">
    <div class="row mb-3">
        
        <div class="col-md-3">
            <label>{{ __('contreq.fromdate1') }}</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>{{ __('contreq.todate') }}</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block">بحث</button>
        </div>
    </div>
</form>
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.complamintdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.comstatusid') }}</th>
                    <th>{{ __('contreq.descr') }}</th>
                    <th>{{ __('contreq.comreasonid') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($complamints as $complamint)
                    <tr>
                        <td>{{ $complamint->id }}</td>
                        <td>{{ $complamint->comdate }}</td>
                        <td>{{ $complamint->custname}}</td>
                        <td>{{ $complamint->type_label }}</td>
                        <td> {{$complamint->descr }}</td>
                        <td> {{$complamint->name }}</td>
                        <td>
                        <form action="{{ route('destroycomplamint',$complamint->id) }}" method="Post">
                        @if($complamint->comstatusid != 3)       
                        <a class="btn" href="{{ route('complamintedit',$complamint->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="30" height="30"> 
                                </a>
                         @endif
                                @csrf
                                @method('DELETE')
                             <button type="submit" class="btn">
                             <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="30" height="30"> 
                             </button>
                            </form>
                           
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