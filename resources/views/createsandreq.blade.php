
@extends('master')
@section('title',  __('contreq.master52'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
    <!-- Starter Section Section -->
    <div >

      <!-- Section Title -->
      

      <div >
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2 class="text-color">{{ __('contreq.master52') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('home') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('error'))
           <div class="alert alert-danger">
             <p>{{ $message }}</p>
           </div>
        @endif
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form method="GET" action="{{ route('generatesandreq') }}">
    @csrf
    <div class="row flex">
    <div class="w-50 p-3">
        <strong>{{ __('contreq.name') }}</strong>
        <select id="cust" class="form-select" name="cust" value="{{ old('cust') }}" class="form-control">
        <option value="" selected="selected">{{ __('contreq.name') }}</option>
        </select>
        </div>
   <div class="w-25 p-3">
    <Strong >{{ __('contreq.amount') }}</Strong>
    <input type="text" class="form-control" id="amount" name="amount" required>
   </div>
   <div class="w-25 p-3">
    <Strong >{{ __('contreq.reason') }}</Strong>
    <input type="text" class="form-control" id="reason" name="reason" required>
   </div>
</div>
    <button class="btn btn-primary" type="submit">{{ __('contreq.repname') }}</button>
</form>
    </div>
   


    </div><!-- /Starter Section Section -->

  </main>
</div>
@endsection
@section('scripts')
  <!-- Main JS File -->
  </div>
</div>
<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-customers', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#cust').empty();
                    // Add a default option
                    $('#cust').append('<option value="">Select a customer</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, customer) {
                        $('#cust').append('<option value="' + customer.id + '">' + customer.fullname + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories: ', error);
                }
            });
        });
    </script>
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