@extends('master')
@section('title',  __('contreq.pagename29'))


@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename29') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <a class="btn" href="{{ route('createaddition',$employee->id) }}">
                                <img src="{{ asset('images/add.JPG') }}" alt="create" width="30" height="30"> 
                                </a>
        
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.ispercent2') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($additions as $addition)
                    <tr>
                        <td >{{ $addition->id }}</td>
                        <td>{{ $addition->amount }}</td>
                        <td>
                            <form action="{{ route('destroyaddition',$addition->id) }}" method="Post">
                                <a class="btn" href="{{ route('additionedit',$addition->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="30" height="30"> 
                                </a>
                                
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