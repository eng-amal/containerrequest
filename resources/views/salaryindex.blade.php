@extends('master')
@section('title',  __('contreq.pagename39'))
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
        <h2 class="text-color">{{ __('contreq.pagename39') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
<!-- Search Form -->
<form method="GET" action="{{ route('calculateSalaries') }}" >
@csrf
    <label for="month">{{ __('contreq.month') }}</label>
    <input type="month" id="month" name="month" value="{{request('selectedMonth')}}" placeholder="year-month" required>
    <button type="submit" class="btn btn-primary">{{ __('contreq.pagename39') }}</button>
</form>
@if(isset($salaries))
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    
                    <th>{{ __('contreq.name') }}</th>
                    <th>{{ __('contreq.BasicSalary') }}</th>
                    <th>{{ __('contreq.UnpaidDays') }}</th>
                    <th>{{ __('contreq.UnpaidDeduction') }}</th>
                    <th>{{ __('contreq.HealthDays') }}</th>
                    <th>{{ __('contreq.HealthDeduction') }}</th>
                    <th>{{ __('contreq.NetSalary') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($salaries as $salary)
        <tr>
            <td>{{ $salary['name'] }}</td>
            <td>{{ number_format($salary['basic_salary'], 2) }}</td>
            <td>{{ $salary['unpaid_leave_days'] }}</td>
            <td>{{ number_format($salary['unpaid_deduction'], 2) }}</td>
            <td>{{ $salary['health_leave_days'] }}</td>
            <td>{{ number_format($salary['health_deduction'], 2) }}</td>
            <td >{{ number_format($salary['net_salary'], 2) }}</td>
        </tr>
        @endforeach
            </tbody>
        </table>
        @endif
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