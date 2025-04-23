@extends('master')
@section('title',  __('contreq.pagename65'))


@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename65') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <a class="btn" href="{{ route('createsecclass',$basicclass->id) }}">
                                <img src="{{ asset('images/add.JPG') }}" alt="create" width="30" height="30"> 
                                </a>
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.name') }}</th>
                    <th>{{ __('contreq.enname') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($secclasss as $secclass)
                    <tr>
                        <td >{{ $secclass->id }}</td>
                        <td>{{ $secclass->name }}</td>
                        <td>{{ $secclass->enname }}</td>
                        <td>
                            <form action="{{ route('destroysecclass',$secclass->id) }}" method="Post">
                                
                                
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
