@extends('master')
@section('title',  __('contreq.pagename68'))
@section('head')
<style>
    .row-warning {
    background-color:rgb(238, 171, 171) !important;
    border:2 px solid;
    color: #721c24; /* Dark red text */
    box-shadow: 0px 2px 5px rgba(255, 0, 0, 0.3);
}
.row-warning img {
    filter: hue-rotate(90deg); /* You can also modify the icon color using CSS if you want */
}
</style>
@endsection
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename68') }}</h2>
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
                    <th>{{ __('contreq.model') }}</th>
                    <th>{{ __('contreq.carno') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->no }}</td>
                        @php
                     // Find the latest carexamin record for the car
                     $carexamin = isset($carexamins[$car->id]) ? $carexamins[$car->id] : null;
                     $expiryDate = $carexamin ? \Carbon\Carbon::parse($carexamin->todate) : null;
                     $oneMonthLater = \Carbon\Carbon::now()->addMonth(); // One month from today

                     $operationcard = isset($operationcards[$car->id]) ? $operationcards[$car->id] : null;
                     $expiryDateop = $operationcard ? \Carbon\Carbon::parse($operationcard->todate) : null;
                     $oneMonthLater = \Carbon\Carbon::now()->addMonth(); // One month from today
                       @endphp
                        <td >
                            <form action="{{ route('destroycar',$car->id) }}" method="Post">
                                <a title="Edit" class="btn" href="{{ route('caredit',$car->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="20" height="20"> 
                                </a>
                                
                                @if ($expiryDate && $expiryDate->lessThanOrEqualTo($oneMonthLater))
                                <a class="btn" title="renew carexamin" href="{{ route('carexaminindex', $car->id) }}"> 
                                <img src="{{ asset('images/stay4.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @else
                                <a class="btn" title="carexamin" href="{{ route('carexaminindex', $car->id) }}"> 
                                <img src="{{ asset('images/stay2.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @endif
                                @if ($expiryDateop && $expiryDateop->lessThanOrEqualTo($oneMonthLater))
                                <a class="btn" title="renew operationcard" href="{{ route('operationcardindex', $car->id) }}"> 
                                <img src="{{ asset('images/stay4.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @else
                                <a class="btn" title="operationcard" href="{{ route('operationcardindex', $car->id) }}"> 
                                <img src="{{ asset('images/stay2.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @endif

                                @csrf
                                @method('DELETE')
                             <button type="submit" class="btn">
                             <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="20" height="20"> 
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