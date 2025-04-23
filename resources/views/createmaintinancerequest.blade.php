
@extends('master')
@section('title',  __('contreq.pagename94'))

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
                    <h2 class="text-color">{{ __('contreq.pagename94') }}</h2>
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
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <form action="{{ route('storemaintinancerequest') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
                
                <div class="row flex">
                <div class="w-50 p-3">
                        <strong>{{ __('contreq.contsizeid') }}</strong>
                        <select id="contsizeid" class="form-select" name="contsizeid" value="{{ old('contsizeid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.contsizeid') }}</option>
                         
                        </select>
                        
                        @error('contsizeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contid') }}</strong>
                        <select id="contid" name="contid" class="form-select" value="{{ old('contid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.contid') }}</option>
                         
                        </select>
                        
                        @error('contid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.carno') }}</strong>
                        <select id="carid" name="carid" class="form-select" value="{{ old('carid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.carid') }}</option>
                         
                        </select>
                        
                        @error('carid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   </div>
                   <div class="row flex">
                    <div class="w-75 p-3">
                        <strong>{{ __('contreq.drivernote') }}</strong>
                        <input type="text" name="drivernote" id="drivernote" value="{{ old('drivernote') }}" class="form-control" placeholder="drivernote">
                        @error('drivernote')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
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
  </div>
</div>
<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-containersizes', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#contsizeid').empty();
                    // Add a default option
                    $('#contsizeid').append('<option value="">Select a container size</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, containersize) {
                        $('#contsizeid').append('<option value="' + containersize.id + '">' + containersize.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories: ', error);
                }
            });
        });
    </script>
    <script>
$(document).ready(function(){
    // When the first dropdown changes
    $('#contsizeid').on('change', function(){
        var selectedValue = $(this).val(); // Get the selected value from first dropdown
        $('#contid').append('<option value="">Select a container1:</option>');
        // Check if a value is selected
        if(selectedValue) {
            // Send an AJAX request to get the second select options based on the first select
            $('#contid').append('<option value="">Select a container2:</option>');
            $.ajax({
                url: '/get-containers1',  // Define your route here
                type: 'GET',
                data: { contsid: selectedValue },
                success: function(response) {
                    // Empty the second select before appending new options
                    $('#contid').empty();

                    // Add a default option
                    $('#contid').append('<option value="">Select a container3:</option>');
                    
                    // Populate the second select options from the server response
                    response.options.forEach(function(container) {
                        $('#contid').append('<option value="' + container.id + '">' + container.no + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#contid').append('<option value="">' + error + '</option>');
                    $('#contid').append('<option value="">Select error:</option>');
                }
            });
        } else {
            // If no value is selected, clear the second select options
            $('#contid').empty().append('<option value="">Select aaa street:</option>');
        }
    });
});
</script>

<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-cars', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#carid').empty();
                    // Add a default option
                    $('#carid').append('<option value="">Select a car</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, car) {
                        $('#carid').append('<option value="' + car.id + '">' + car.no + '</option>');
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
            let curaddressLang = "{{ app()->getLocale() }}"; // Get curaddress language (English or Arabic)
            let newLang = curaddressLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

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