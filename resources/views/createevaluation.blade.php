
@extends('master')
@section('title',  __('contreq.pagename83'))

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
                    <h2 class="text-color">{{ __('contreq.pagename83') }}</h2>
                </div>
                
            </div>
        </div>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
      @endif
      <!-- رسالة نجاح -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
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
        <form action="{{ route('storeevaluation') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf      
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.Evaname') }}</strong>
                        <input type="text" id="temname" value="{{ old('temname') }}" name="temname" class="form-control" placeholder="{{ __('contreq.Evaname') }}">
                        @error('temname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.temname') }}</strong>
                        <select id="temid" class="form-select" name="temid" value="{{ old('temid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.temname') }}</option>
                         
                        </select>
                        
                        @error('temid')
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
                url: '/get-tems', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#temid').empty();
                    // Add a default option
                    $('#temid').append('<option value="">Select a tem1</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, tem) {
                        $('#temid').append('<option value="' + tem.id + '">' + tem.name + '</option>');
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