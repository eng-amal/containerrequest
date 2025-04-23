@extends('master')
@section('title',  __('contreq.pagename26'))
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
        <h2 class="text-color">{{ __('contreq.pagename26') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
<!-- Search Form -->
<form method="GET" action="{{ route('employeeindex') }}" class="form-group p-3 flex row">
        <div class="w-25 p-3">
            <label for="search_mobile">{{ __('contreq.searchno') }}</label>
            <input type="text" id="search_mobile" name="search_mobile" value="{{ request('search_mobile') }}">
        </div>

        
        <div class="w-25 p-3">
            <label for="search_cust_name">{{ __('contreq.custname') }}</label>
            <input type="text" id="search_cust_name" name="search_cust_name" value="{{ request('search_cust_name') }}">
        </div>
        <div class="w-25 p-3">
           
        <button  class="btn btn-outline-primary" type="submit">{{ __('contreq.search') }}</button></div>
    </form>

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th width="50px">{{ __('contreq.Id') }}</th>
                    <th width="100px">{{ __('contreq.name') }}</th>
                    <th width="100px">{{ __('contreq.enname') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                @php
                // Get the difference between the employee due date and today's date
                $dueDate = \Carbon\Carbon::parse($employee->duedate);
                $today = \Carbon\Carbon::now();
                $difference = $dueDate->diffInDays($today);
                 @endphp

                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->fullname }}</td>
                        <td>{{ $employee->enfullname }}</td>
                        @php
                     // Find the latest residence record for the employee
                     $residence = isset($stays[$employee->id]) ? $stays[$employee->id] : null;
                     $expiryDate = $residence ? \Carbon\Carbon::parse($residence->todate) : null;
                     $drivercard = isset($drivecards[$employee->id]) ? $drivecards[$employee->id] : null;
                     $expiryDated = $drivercard ? \Carbon\Carbon::parse($drivercard->todate) : null;
                     $oneMonthLater = \Carbon\Carbon::now()->addMonth(); // One month from today
                       @endphp
                        <td >
                            <form action="{{ route('destroyemployee',$employee->id) }}" method="Post">
                                <a title="Edit" class="btn" href="{{ route('employeeedit',$employee->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="20" height="20"> 
                                </a>
                                <a  title="vacation" class="btn" href="{{ route('vacationindex', $employee->id) }}"> 
                                <img src="{{ asset('images/vac.JPG') }}" alt="view" width="20" height="20">
                                </a>
                               
                                
                                <a class="btn" title="decision"  href="{{ route('decisionindex', $employee->id) }}" > 
                                <img src="{{ asset('images/file.JPG') }}" alt="add" width="20" height="20">
                                </a>
                               
                                <a class="btn" title="addition"  href="{{ route('additionindex', $employee->id) }}" > 
                                <img src="{{ asset('images/addition.JPG') }}" alt="add" width="20" height="20">
                                </a>
                                @if ($expiryDate && $expiryDate->lessThanOrEqualTo($oneMonthLater))
                                <a class="btn" title="renew residence" href="{{ route('stayindex', $employee->id) }}"> 
                                <img src="{{ asset('images/stay4.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @else
                                <a class="btn" title="residence" href="{{ route('stayindex', $employee->id) }}"> 
                                <img src="{{ asset('images/stay2.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @endif
                                @if ($expiryDated && $expiryDated->lessThanOrEqualTo($oneMonthLater))
                                <a class="btn" title="renew drivercard" href="{{ route('drivercardindex', $employee->id) }}"> 
                                <img src="{{ asset('images/stay4.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @else
                                <a class="btn" title="drivercard" href="{{ route('drivercardindex', $employee->id) }}"> 
                                <img src="{{ asset('images/stay2.JPG') }}" alt="view" width="20" height="20">
                                </a>
                                @endif
                                <a class="btn" title="Evaluation" href="{{ route('employee.evaluation', $employee->id) }}"> 
                                <img src="{{ asset('images/eva.JPG') }}" alt="evaluation" width="20" height="20">
                                </a>
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