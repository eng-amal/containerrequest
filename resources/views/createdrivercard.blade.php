
@extends('master')
@section('title',  __('contreq.pagename75'))

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
                    <h2 class="text-color">{{ __('contreq.pagename75') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('drivercardindex', $car->id) }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storedrivercard') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input type="hidden" name="empid" value="{{ $employee->id }}">
                    
            
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.cardno') }}</strong>
                        <input type="text" requerid name="cardno" id="cardno" value="{{ old('cardno') }}"  class="form-control" placeholder="{{ __('contreq.cardno') }}">
                        @error('cardno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.driverno') }}</strong>
                        <input type="text" requerid name="driverno" id="driverno" value="{{ old('driverno') }}"  class="form-control" placeholder="{{ __('contreq.driverno') }}">
                        @error('driverno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fromdate1') }}</strong>
                        <input type="date" requerid name="fromdate" id="fromdate" value="{{ old('fromdate') }}" id="fromdate" class="form-control" placeholder="{{ __('contreq.fromdate') }}">
                        @error('fromdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input type="date" requerid name="todate" id="todate" value="{{ old('todate') }}" id="todate" class="form-control" placeholder="{{ __('contreq.fromdate') }}">
                        @error('todate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.empid') }}</strong>
                        <select id="empid" name="empid" class="form-select" value="{{ old('empid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.empid') }}</option>
                       
                        </select>
                        
                        @error('empid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.category') }}</strong>
                        <input type="text" requerid name="category" id="category" value="{{ old('category') }}"  class="form-control" placeholder="{{ __('contreq.category') }}">
                        @error('category')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.moinumber') }}</strong>
                        <input type="text" requerid name="moinumber" id="moinumber" value="{{ old('moinumber') }}"  class="form-control" placeholder="{{ __('contreq.moinumber') }}">
                        @error('moinumber')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.moiname') }}</strong>
                        <input type="text" requerid name="moiname" id="moiname" value="{{ old('moiname') }}"  class="form-control" placeholder="{{ __('contreq.moiname') }}">
                        @error('moiname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    
                   <div class="row flex">
                    <div class="w-25 p-3">
                    <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
            <!-- </div> -->
        </form>
    </div>
    </div><!-- /Starter Section Section -->

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
    <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-employees', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#empid').empty();
                    // Add a default option
                    $('#empid').append('<option value="">Select employee:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, employee) {
                        $('#empid').append('<option value="' + employee.id + '">' + employee.fullname + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching employees: ', error);
                }
            });
        });
    </script>
@endsection