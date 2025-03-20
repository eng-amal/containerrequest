
@extends('master')
@section('title',  __('contreq.pagename24'))

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
                    <h2 class="text-color">{{ __('contreq.pagename24') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('employeeindex') }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storeemployee') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            
                    
                   
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" id="fullname" value="{{ old('fullname') }}" name="fullname" class="form-control" placeholder="{{ __('contreq.name') }}">
                        @error('fullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.enname') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="enfullname" value="{{ old('enfullname') }}" name="enfullname" class="form-control"  placeholder="{{ __('contreq.enname') }}">
                        @error('enfullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobileno" value="{{ old('mobileno') }}" id="mobileno"  class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobileno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                   </div>
                   <div class="row flex">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.birthdate') }}</strong>
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" class="form-control" placeholder="birthdate">
                        @error('birthdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.hiredate') }}</strong>
                        <input type="date" name="hiredate" id="hiredate" value="{{ old('hiredate') }}" class="form-control" placeholder="hiredate">
                        @error('hiredate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.address') }}</strong>
                        <input type="text" required name="address" id="address" value="{{ old('address') }}" class="form-control" placeholder="{{ __('contreq.address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mainsal') }}</strong>
                        <input type="text" name="mainsal" id="mainsal" value="{{ old('mainsal') }}" class="form-control" placeholder="mainsal">
                        @error('mainsal')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.department') }}</strong>
                        <select id="department_id" class="form-select" name="department_id" value="{{ old('department_id') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.department') }}</option>
                         
                        </select>
                        
                        @error('department_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.position') }}</strong>
                        <select id="position_id" name="position_id" class="form-select" value="{{ old('position_id') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.position') }}</option>
                         
                        </select>
                        
                        @error('position_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.nationality') }}</strong>
                        <select id="nationality" class="form-select" name="nationality" value="{{ old('nationality') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.nationality') }}</option>
                         
                        </select>
                        
                        @error('nationality')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.empimg') }}</strong>
                        <input type="file" name="empimg" value="{{ old('empimg',0) }}" class="form-control" placeholder="{{ __('contreq.empimg') }}">
                        @error('empimg')
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
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-departments', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#department_id').empty();
                    // Add a default option
                    $('#department_id').append('<option value="">Select a department1</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, department) {
                        $('#department_id').append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories: ', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-nationalitys', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#nationality').empty();
                    // Add a default option
                    $('#nationality').append('<option value="">Select nationality:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, nationality) {
                        $('#nationality').append('<option value="' + nationality.id + '">' + nationality.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities: ', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-positions', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#position_id').empty();
                    // Add a default option
                    $('#position_id').append('<option value="">Select position:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, position) {
                        $('#position_id').append('<option value="' + position.id + '">' + position.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities: ', error);
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