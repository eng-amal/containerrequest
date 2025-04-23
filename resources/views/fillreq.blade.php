<!DOCTYPE html>
<html lang="en">
<html lang="{{ app()->getLocale() }}">
@extends('master')
@section('title',  __('contreq.pagename4'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
      <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename4') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ url('/showRequests') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.id') }}</strong>
                        <input type="text" name="conreqid" value="{{ $containerrequest->id }}" class="form-control" readonly placeholder="id">
                        @error('conreqid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input type="text" name="custname" readonly value="{{ $containerrequest->custname }}" class="form-control" placeholder="{{ __('contreq.custname') }}">
                        @error('custname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobno" readonly value="{{ $containerrequest->mobno }}" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input type="text" name="whatno" readonly value="{{ $containerrequest->whatno }}" class="form-control" placeholder="{{ __('contreq.whatno') }}">
                        @error('whatno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contsizeid') }}</strong>
                        <select id="contsizeid" name="contsizeid" class="form-control">
                         <option value="">{{ __('contreq.contsizeid') }}</option>
                          @foreach ($containersizes as $cont)
                          <option value="{{ $cont->id }}" {{ $containerrequest->contsizeid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('contsizeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" name="cityid" class="form-control">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($citys as $city)
                          <option value="{{ $city->id }}" {{ $containerrequest->cityid == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('cityid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.street') }}</strong>
                        <select id="streetid" name="streetid" class="form-control">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($streets as $street)
                          <option value="{{ $street->id }}" {{ $containerrequest->streetid == $street->id ? 'selected' : '' }}>
                        {{ $street->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('streetid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                    <a href="{{ $containerrequest->dcontlocation }}" target="_blank">{{ __('contreq.location_url') }}</a>
                        
                        <input type="text" name="dcontlocation" value="{{ $containerrequest->dcontlocation }}" class="form-control"  placeholder="Paste Google Maps Location URL here">
                        @error('dcontlocation')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fromdate') }}</strong>
                        <input type="date" name="liftdate" id="liftdate" value="{{ old('liftdate') }}" class="form-control" placeholder="liftdate">
                        @error('liftdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.empid') }}</strong>
                        <select id="empid" name="empid" value="{{ old('empid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.empid') }}</option>
                       
                        </select>
                        
                        @error('empid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contid') }}</strong>
                        <select id="contid" name="contid" class="form-control">
                         <option value="">{{ __('contreq.contid') }}</option>
                          @foreach ($containers as $conta)
                          
                          <option value="{{ $conta->id }}" {{ $containerrequest->contid == $conta->id ? 'selected' : '' }}>
                        {{ $conta->no }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('contid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.location_url') }}</strong>
                        <input type="text" name="conlocation" value="{{ old('conlocation') }}" class="form-control" required placeholder="Paste Google Maps Location URL here">
                        @error('conlocation')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.conimg') }}</strong>
                        <input type="file" name="conimg" value="{{ old('conimg') }}" class="form-control" placeholder="{{ __('contreq.conimg') }}">
                        @error('conimg')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.liftreason') }}</strong>
                        <select id="liftreasonid" name="liftreasonid" value="{{ old('liftreasonid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.liftreason') }}</option>
                      
                        </select>
                        
                        @error('liftreasonid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3" id="bldeh" name="bldeh" style="display: none;">
                        <strong>{{ __('contreq.bldeh') }}</strong>
                        <select id="bldehid" name="bldehid" value="{{ old('bldehid') }}" class="form-control" >
                         <option value="" selected="selected">{{ __('contreq.bldeh') }}</option>
                      
                        </select>
                        
                        @error('bldehid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3" id="notediv" name="notediv" style="display: none;">
                        <strong>{{ __('contreq.note') }}</strong>
                        <input type="text" name="note" value="{{ old('note') }}" class="form-control" placeholder="{{ __('contreq.note') }}">
                        @error('note')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.liftprority') }}</strong>
                        <select id="liftprorityid" name="liftprorityid" value="{{ old('liftprorityid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.liftprority') }}</option>
                      
                        </select>
                        
                        @error('liftprorityid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3">
                <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
            
        </form>
    </div>

   

  </main>
</div>
@endsection
@section('scripts')
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
                url: '/get-containers',  // Define your route here
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
            $('#streetid').empty().append('<option value="">Select aaa street:</option>');
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
<script>
$(document).ready(function(){
    // When the first dropdown changes
    $('#cityid').on('change', function(){
        var selectedValue = $(this).val(); // Get the selected value from first dropdown
        $('#streetid').append('<option value="">Select astreet:</option>');
        // Check if a value is selected
        if(selectedValue) {
            // Send an AJAX request to get the second select options based on the first select
            $('#streetid').append('<option value="">Select astreet2:</option>');
            $.ajax({
                url: '/get-streets',  // Define your route here
                type: 'GET',
                data: { cityid: selectedValue },
                success: function(response) {
                    // Empty the second select before appending new options
                    $('#streetid').empty();

                    // Add a default option
                    $('#streetid').append('<option value="">Select astreet:</option>');
                    
                    // Populate the second select options from the server response
                    response.options.forEach(function(street) {
                        $('#streetid').append('<option value="' + street.id + '">' + street.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#streetid').append('<option value="">' + error + '</option>');
                    $('#streetid').append('<option value="">Select error:</option>');
                }
            });
        } else {
            // If no value is selected, clear the second select options
            $('#streetid').empty().append('<option value="">Select aaa street:</option>');
        }
    });
});
</script>

<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-liftreasons', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#liftreasonid').empty();
                    // Add a default option
                    $('#liftreasonid').append('<option value="">Select liftreason:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, liftreason) {
                        $('#liftreasonid').append('<option value="' + liftreason.id + '">' + liftreason.name + '</option>');
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
        // Trigger when the date changes
        $('#liftdate').on('change', function() {
            const fromDate = $(this).val();

            if (fromDate) {
                $.ajax({
                    url: '/get-drivers',
                    method: 'GET',
                    data: { requestdate: fromDate }, // send it as query param
                    success: function(response) {
                        $('#empid').empty();
                        $('#empid').append('<option value="">Select employee:</option>');

                        $.each(response, function(index, employee) {
                            $('#empid').append('<option value="' + employee.id + '">' + employee.fullname + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching employees: ', error);
                    }
                });
            } else {
                // If date is cleared, you might want to clear the dropdown
                $('#empid').empty();
                $('#empid').append('<option value="">Select employee:</option>');
            }
        });
    });
</script>
    <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-liftproritys', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#liftprorityid').empty();
                    // Add a default option
                    $('#liftprorityid').append('<option value="">Select liftprority:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, liftprority) {
                        $('#liftprorityid').append('<option value="' + liftprority.id + '">' + liftprority.name + '</option>');
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
                url: '/get-bldehs', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#bldehid').empty();
                    // Add a default option
                    $('#bldehid').append('<option value="">Select bldeh:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, bldeh) {
                        $('#bldehid').append('<option value="' + bldeh.id + '">' + bldeh.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities: ', error);
                }
            });
        });
    </script>
    <script>
        $('#liftreasonid').change(function() {
            
            var liftMethod = $(this).val();
            if (liftMethod === '2')
             {
                $('#bldeh').show();
                
             }
             else
             {
                $('#bldeh').hide();
                
             }
             if (liftMethod === '5')
             {
                $('#notediv').show();
                
             }
             else
             {
                $('#notediv').hide();
                
             }
             
           
        });

        
    </script>

@endsection