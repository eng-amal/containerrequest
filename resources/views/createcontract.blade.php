
@extends('master')
@section('title',  __('contreq.pagename12'))
@section('head')

  <style>
        /* Basic styling for the modal */
        #customerModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 50px;
        }
        #modalContent {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }
    </style>
    @endsection
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
                    <h2 class="text-color">{{ __('contreq.pagename12') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('contractindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('storecontract') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
           
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contractdate') }}</strong>
                        <input class="form-control" dir="auto" type="date" value="{{ old('contractdate') }}" name="contractdate" id="contractdate" class="form-control"  placeholder="{{ __('contreq.reqdate') }}">
                        @error('contractdate')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
               
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" id="mobileno" value="{{ old('mobileno') }}" name="mobileno" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobileno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input class="form-control" dir="auto" type="text" id="custname" value="{{ old('custname') }}" name="custname" class="form-control" readonly placeholder="{{ __('contreq.custname') }}">
                        @error('custname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input type="text" name="whatno" value="{{ old('whatno') }}" id="whatno" readonly class="form-control" placeholder="{{ __('contreq.whatno') }}">
                        @error('whatno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                   </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contsizeid') }}</strong>
                        <select id="contsizeid" class="form-select" name="contsizeid" value="{{ old('contsizeid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.contsizeid') }}</option>
                         
                        </select>
                        
                        @error('contsizeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contnum') }}</strong>
                        <input type="text" name="contnum" id="contnum" value="{{ old('contnum') }}" id="contnum" class="form-control" placeholder="{{ __('contreq.contnum') }}">
                        @error('contnum')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" class="form-select" name="cityid" value="{{ old('cityid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.city') }}</option>
                         
                        </select>
                        
                        @error('cityid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.street') }}</strong>
                        <select id="streetid" class="form-select" name="streetid" value="{{ old('streetid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.street') }}</option>
                        
                        </select>
                        
                        @error('streetid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.location_url') }}</strong>
                        <input type="text" name="location" value="{{ old('location') }}" class="form-control" required placeholder="Paste Google Maps Location URL here">
                        @error('location')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.note') }}</strong>
                        <input type="text" name="note" value="{{ old('note') }}" class="form-control" required placeholder="{{ __('contreq.note') }}">
                        @error('note')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.Commregister') }}</strong>
                        <input type="text" name="Commregister" value="{{ old('Commregister') }}" class="form-control" required placeholder="{{ __('contreq.Commregister') }}">
                        @error('Commregister')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.address') }}</strong>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-control" required placeholder="{{ __('contreq.address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.Wastetype') }}</strong>
                        <select id="Wastetypeid" name="Wastetypeid" class="form-select" value="{{ old('Wastetypeid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.Wastetype') }}</option>
                       
                        </select>
                        
                        @error('Wastetypeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.fromdate') }}</strong>
                        <input type="date" name="fromdate" id="fromdate" value="{{ old('fromdate') }}" class="form-control" placeholder="fromdate">
                        @error('fromdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input type="date" name="todate" id="todate" value="{{ old('todate') }}" class="form-control" placeholder="todate">
                        @error('todate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.emptycost') }}</strong>
                        <input type="text" name="emptycost" id="emptycost" value="{{ old('emptycost') }}" class="form-control" required placeholder="{{ __('contreq.emptycost') }}">
                        @error('emptycost')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.emptynum') }}</strong>
                        <input type="text" name="emptynum" id="emptynum" value="{{ old('emptynum') }}" class="form-control" required placeholder="{{ __('contreq.emptynum') }}">
                        @error('emptynum')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                      <div class="w-25 p-3">
                        <strong>{{ __('contreq.cost') }}</strong>
                        <input type="text" name="cost" value="{{ old('cost') }}" id="cost"  class="form-control" placeholder="{{ __('contreq.cost') }}">
                        @error('cost')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytypeid" class="form-select" name="paytypeid" value="{{ old('paytypeid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.paytype') }}</option>
                      
                        </select>
                        
                        @error('paytypeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3" id="bankdiv" name="bankdiv" style="display: none;">
                        <strong>{{ __('contreq.payperoid') }}</strong>
                        <select id="payperoidid" class="form-select" name="payperoidid" value="{{ old('payperoidid') }}" class="form-control" >
                         <option value="" selected="selected">{{ __('contreq.payperoid') }}</option>
                      
                        </select>
                        
                        @error('payperoidid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="row flex">
                    <div class="w-25 p-3">
                    <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
            <!-- </div> -->
        </form>
    </div>
    <div id="customerModal">
        <div id="modalContent">
            <h2>{{ __('contreq.addcust') }}</h2>
            <form id="createCustomerForm">
            @csrf
                <label for="newName">{{ __('contreq.custname') }}</label>
                <input type="text" id="fullname" name="fullname" required><br><br>

                <label for="newMob">{{ __('contreq.mobno') }}</label>
                <input type="text" id="phone" name="phone" required><br><br>
                <label for="newwhatappno">{{ __('contreq.whatno') }}</label>
                <input type="text" id="whatappno" name="whatappno"><br><br>
                <button type="submit">{{ __('contreq.submit') }}</button>
            </form>
            <button id="closeModal">{{ __('contreq.close') }}</button>
        </div>
    </div>
    </div><!-- /Starter Section Section -->

  </main>
</div>
@endsection
@section('scripts')
  <!-- Main JS File -->

<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-wastetypes', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#Wastetypeid').empty();
                    // Add a default option
                    $('#Wastetypeid').append('<option value="">Select a Wastetype</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, Wastetype) {
                        $('#Wastetypeid').append('<option value="' + Wastetype.id + '">' + Wastetype.name + '</option>');
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
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-cities', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#cityid').empty();
                    // Add a default option
                    $('#cityid').append('<option value="">Select city:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, city) {
                        $('#cityid').append('<option value="' + city.id + '">' + city.name + '</option>');
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
                url: '/get-contractpaytypes', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#paytypeid').empty();
                    // Add a default option
                    $('#paytypeid').append('<option value="">Select paytype:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, pay) {
                        $('#paytypeid').append('<option value="' + pay.id + '">' + pay.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching paytypes: ', error);
                }
            });
        });
    </script>
       
       <script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-payperoids', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#payperoidid').empty();
                    // Add a default option
                    $('#payperoidid').append('<option value="">Select payperoid:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, payperoid) {
                        $('#payperoidid').append('<option value="' + payperoid.id + '">' + payperoid.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching employees: ', error);
                }
            });
        });
    </script>
    
<script>
$(document).ready(function(){
    $('#emptynum').on('change', function(){
            console.log('emptynum change event fired');
            var numOfEmpty = $(this).val();
            let fromDate = new Date(document.getElementById('fromdate').value);
            let toDate = new Date(document.getElementById('todate').value);
            let emptyCost = parseFloat(document.getElementById('emptycost').value);
            let contnum = parseInt(document.getElementById('contnum').value);
            // Check if all inputs are valid
            if (isNaN(emptyCost) ||isNaN(contnum) || isNaN(numOfEmpty) || isNaN(fromDate) || isNaN(toDate)) {
                alert('Please enter all values correctly.');
                return;
            }

            // Calculate the difference in months
            let monthDiff = (toDate.getFullYear() - fromDate.getFullYear()) * 12 + (toDate.getMonth() - fromDate.getMonth());

            // If the 'fromdate' is later than 'todate', alert the user
            if (monthDiff < 0) {
                alert('The "From Date" must be earlier than the "To Date".');
                return;
            }

            // Calculate the total cost
            let totalCost =contnum* emptyCost * numOfEmpty * monthDiff;

            // Display the result
            document.getElementById('cost').value = totalCost;
             
           
        });
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
        // jQuery to listen for changes in the customerid input field
        $('#mobileno').on('input', function() {
            var customerId = $(this).val(); // Get the customer ID entered by the user

            if (customerId.length > 0) {
                // Make AJAX request to the server to fetch customer details
                $.ajax({
                    url: '/get-customer/' + customerId,  // URL that calls the controller method
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Populate the customer information input field with the returned data
                            $('#custname').val(response.data.fullname);
                            $('#whatno').val(response.data.whatappno);
                            // Adjust based on fields in the customer model
                        } else {
                            // If no customer found, display an error message in the input
                            $('#custname').val('');
                            $('#whatno').val('');
                            
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                        $('#custname').val('Error fetching data');
                    }
                });
            } else {
                // Clear customerinfo if customerid is empty
                $('#custname').val('');
            }
        });


        // Close the modal when clicking the close button
        $('#closeModal').on('click', function() {
            $('#customerModal').hide();  // Hide the modal
        });

        // Close the modal when clicking the close button
        $('#openModal').on('click', function() {
            $('#customerModal').show();  // Hide the modal
        });

        // Handle form submission to create a new customer via AJAX
        $('#createCustomerForm').on('submit', function(e) {
            e.preventDefault();  // Prevent default form submission

            var customerData = $(this).serialize();  // Serialize form data

            // Make AJAX request to create a new customer
            $.ajax({
                url: '/create-customer',
                type: 'POST',
                data: customerData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Customer created successfully!');
                        $('#custname').val(response.data.fullname);
                        $('#whatno').val(response.data.whatappno);
                        $('#mobileno').val(response.data.phone);
                        $('#customerModal').hide();  // Hide the modal
                    } else {
                        alert('Customer not added!');
                        alert('Error: ' + response.message);
                        $('#customerModal').hide(); 
                    }
                },
                error: function(xhr, status, error) {
                    alert('Customer not added!');
                    console.error("AJAX Error: " + status + " - " + error);
                }
            });
        });
    </script>

<script>
        $('#paytypeid').change(function() {
            
            var paymentMethod = $(this).val();
            if (paymentMethod === '2' ||paymentMethod === '4')
             {
                
                $('#bankdiv').show();
                
             }
             else
             {
                
                $('#bankdiv').hide();
                
             }
             
           
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