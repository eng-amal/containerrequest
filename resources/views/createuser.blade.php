
@extends('master')
@section('title',  __('contreq.pagename40'))

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
                    <h2 class="text-color">{{ __('contreq.pagename40') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('userindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('error'))
           <div class="alert alert-danger">
             <p>{{ $message }}</p>
           </div>
        @endif
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('storeuser') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf      
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.username') }}</strong>
                        <input type="text" id="username" value="{{ old('username') }}" name="username" class="form-control" placeholder="{{ __('contreq.username') }}">
                        @error('username')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.password') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="password" value="{{ old('password') }}" name="password" class="form-control"  placeholder="{{ __('contreq.password') }}">
                        @error('password')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
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
                        <strong>{{ __('contreq.role_id') }}</strong>
                        <select id="role_id" class="form-select" name="role_id" value="{{ old('role_id') }}" >
                        <option value="0" {{ old('role_id') == 0 ? 'selected' : '' }}>{{ __('contreq.role_id1') }}</option>
                        <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>{{ __('contreq.role_id2') }}</option>
                        <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>{{ __('contreq.role_id3') }}</option>
                        <option value="3" {{ old('role_id') == 3 ? 'selected' : '' }}>{{ __('contreq.role_id4') }}</option>
                        </select>
                        
                        @error('role_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
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
        // Function to toggle the language between English and Arabic
        function toggleLanguage() {
            let currentLang = "{{ app()->getLocale() }}"; // Get current language (English or Arabic)
            let newLang = currentLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

            // Add the new language to the form as a hidden input
            let form = document.getElementById('language-form');
            let langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.username = 'lang';
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