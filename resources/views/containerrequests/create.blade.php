
@extends('master')
@section('title',  __('contreq.pagename'))
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
                    <h2 class="text-color">{{ __('contreq.pagename') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('containerrequests.index') }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('containerrequests.store') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input id="reqid" name="reqid" hidden value="{{ old('reqid') }}">
                    
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.reqtypeid') }}</strong>
                        <select id="reqtypeid" class="form-select" name="reqtypeid">
                         <option value="" selected="selected">{{ __('contreq.reqtypeid') }}</option>
                         <option value="1" {{ old('reqtypeid') == 1 ? 'selected' : '' }}>{{ __('contreq.reqtype1') }}</option>
                        <option value="2" {{ old('reqtypeid') == 2 ? 'selected' : '' }}>{{ __('contreq.reqtype2') }}</option>
                        </select>
                        
                        @error('reqtypeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">   
                     <a href="#" id="openPopup" class="btn btn-primary">Select Request</a>
                    </div>
                <div class="row flex">
                <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" id="mobno" value="{{ old('mobno') }}" name="mobno" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
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
                    <div class="w-25 p-3">
                     <a href="javascript:void(0);" id="openModal">{{ __('contreq.addcust') }}</a>
                    </div>
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
                        <strong>{{ __('contreq.rent') }}</strong>
                        <input type="number" required name="rent" id="rent" value="{{ old('rent') }}" class="form-control" placeholder="{{ __('contreq.rent') }}">
                        @error('rent')
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
                        <strong>{{ __('contreq.cost') }}</strong>
                        <input type="text" name="cost" value="{{ old('cost') }}" id="cost" class="form-control" placeholder="{{ __('contreq.cost') }}">
                        @error('cost')
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
                        <strong>{{ __('contreq.bank') }}</strong>
                        <select id="bankid" class="form-select" name="bankid" value="{{ old('bankid') }}" class="form-control" >
                         <option value="" selected="selected">{{ __('contreq.bank') }}</option>
                      
                        </select>
                        
                        @error('bankid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3" id="transferdiv" name="transferdiv" style="display: none;">
                        <strong>{{ __('contreq.transferimg') }}</strong>
                        <input type="file" name="transferimg" value="{{ old('transferimg',0) }}" class="form-control" placeholder="{{ __('contreq.transferimg') }}">
                        @error('transferimg')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3" id="paymountdiv" name="paymountdiv" style="display: none;">
                        <strong>{{ __('contreq.payamount') }}</strong>
                        <input type="text" id="payamount" name="payamount" value="{{ old('payamount',0) }}" class="form-control" placeholder="{{ __('contreq.payamount') }}">
                        @error('payamount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="remainmountdiv" name="remainmountdiv" style="display: none;">
                        <strong>{{ __('contreq.remainamount') }}</strong>
                        <input type="text" id="remainamount" name="remainamount" value="{{ old('remainamount',0) }}" class="form-control" placeholder="{{ __('contreq.remainamount') }}">
                        @error('remainamount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.location_url') }}</strong>
                        <input type="text" id="contlocation" name="contlocation" value="{{ old('contlocation') }}" class="form-control" required placeholder="Paste Google Maps Location URL here">
                        @error('contlocation')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
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
                <input class="form-control" type="text" id="fullname" value="{{ __('contreq.custname1') }}" name="fullname" required><br><br>

                <label for="newMob">{{ __('contreq.mobno') }}</label>
                <input class="form-control" type="text" id="phone" name="phone" required><br><br>
                <label for="newwhatappno">{{ __('contreq.whatno') }}</label>
                <input class="form-control"  type="text" id="whatappno" name="whatappno"><br><br>
                <button  class="btn btn-outline-primary" type="submit">{{ __('contreq.submit') }}</button>
            </form>
            <button  class="btn btn-outline-primary" id="closeModal">{{ __('contreq.close') }}</button>
        </div>
    </div>
<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestModalLabel">Select Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="searchInput" class="form-control mb-2" placeholder="Search by Name or Mobile">

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Customer Name</th>
              <th>Mobile No</th>
              <th>Request Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="requestTable">
            <!-- Data will be inserted here via jQuery -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
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
$(document).ready(function () {
    // Open popup and load data
    $("#openPopup").click(function () {
        $.ajax({
            url: "{{ route('getRequests') }}",
            method: "GET",
            success: function (data) {
                let tableContent = "";
                $.each(data, function (index, request) {
                    tableContent += `<tr data-custname="${request.custname}" data-mobno="${request.mobno}" data-whatno="${request.whatno}" data-reqid="${request.id}" data-cost="${request.cost}" data-loc="${request.contlocation}" data-cityid="${request.cityid}" data-streetid="${request.streetid}" data-contsizeid="${request.contsizeid}">
                                        <td>${request.custname}</td>
                                        <td>${request.mobno}</td>
                                        <td>${request.reqdate}</td>
                                        <td><button class="btn btn-success select-request">Select</button></td>
                                     </tr>`;
                });
                $("#requestTable").html(tableContent);
                $("#requestModal").modal("show");
            }
        });
    });

    // Filter table data
    $("#searchInput").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        $("#requestTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Select row and fill form inputs
    $(document).on("click", ".select-request", function () {
        let row = $(this).closest("tr");
        let selectedCityId = row.data("cityid");
        let selectedStreetId = row.data("streetid");
        let selectedContId = row.data("contsizeid");
        $("#custname").val(row.data("custname"));
        $("#mobno").val(row.data("mobno"));
        $("#whatno").val(row.data("whatno"));
        $("#reqid").val(row.data("reqid"));
        $("#cost").val(row.data("cost"));
        $("#contlocation").val(row.data("loc"));
        if ($("#cityid option[value='" + selectedCityId + "']").length > 0) {
        $("#cityid").val(selectedCityId).trigger("change"); // Trigger change event to update UI if needed
    }
    
    if ($("#contsizeid option[value='" + selectedContId + "']").length > 0) {
        $("#contsizeid").val(selectedContId).trigger("change"); // Trigger change event to update UI if needed
    }
    setTimeout(function () {
            if ($("#streetid option[value='" + selectedStreetId + "']").length > 0) {
                $("#streetid").val(selectedStreetId);
            } else {
                alert("Selected request's street is not in the list.");
            }
        }, 1000);
        $("#requestModal").modal("hide");
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function fetchCost() {
        let rent = document.getElementById("rent").value;
        let contsizeid = document.getElementById("contsizeid").value;
        let costInput = document.getElementById("cost");

        if (rent && contsizeid) {
            fetch(`/get-cost?rent=${rent}&contsizeid=${contsizeid}`)
                .then(response => response.json())
                .then(data => {
                    if (data.cost !== null) {
                        costInput.value = data.cost;
                    } else {
                        costInput.value = "No cost found";
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    document.getElementById("rent").addEventListener("input", fetchCost);
    document.getElementById("contsizeid").addEventListener("change", fetchCost);
});
</script>

<script>
        $(document).ready(function() {
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-banks', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#bankid').empty();
                    // Add a default option
                    $('#bankid').append('<option value="">Select a bank</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, bank) {
                        $('#bankid').append('<option value="' + bank.id + '">' + bank.name + '</option>');
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
                url: '/get-paytypes', // The route to fetch data
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
        // Trigger when the date changes
        $('#fromdate').on('change', function() {
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
$(document).ready(function(){
    // When the first dropdown changes
    $('#cityid').on('change', function(){
        var selectedValue = $(this).val(); // Get the selected value from first dropdown
        $('#streetid').append('<option value="">Select astreet1:</option>');
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
                    $('#streetid').append('<option value="">Select astreet3:</option>');
                    
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
    document.getElementById('rent').addEventListener('input', calculateToDate);
    document.getElementById('fromdate').addEventListener('change', calculateToDate);

    function calculateToDate() {
        let fromDate = document.getElementById('fromdate').value;
        let rentDays = parseInt(document.getElementById('rent').value, 10)-1;

        if (fromDate && !isNaN(rentDays) && rentDays > 0) {
            let fromDateObj = new Date(fromDate);
            fromDateObj.setDate(fromDateObj.getDate() + rentDays);
            
            let toDate = fromDateObj.toISOString().split('T')[0]; // Format as YYYY-MM-DD
            document.getElementById('todate').value = toDate;
        }
    }
</script>
<script>
    document.getElementById('payamount').addEventListener('input', calculateRemain);
    

    function calculateRemain() {
        let costs = parseInt(document.getElementById('cost').value,10);
        let paymount = parseInt(document.getElementById('payamount').value, 10);

        if (costs>0 && paymount > 0) {
            let remain = costs-paymount;
            document.getElementById('remainamount').value = remain;
        }
    }
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
            $('#contid').empty().append('<option value="">Select aaa street:</option>');
        }
    });
});
</script>

<script>
        // jQuery to listen for changes in the customerid input field
        $('#mobno').on('input', function() {
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
                        $('#mobno').val(response.data.phone);
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
            var amount = $('#cost').val();
            var customerId = $('#mobno').val();
            if (paymentMethod === '3' ||paymentMethod === '6')
             {
                $('#transferdiv').show();
                $('#bankdiv').show();
                $('#paymountdiv').show();
                $('#remainmountdiv').show();
                
             }
             else
             {
                $('#transferdiv').hide();
                $('#bankdiv').hide();
                $('#paymountdiv').hide();
                $('#remainmountdiv').hide();
             }
             
            if (paymentMethod === '2' && amount) {
                // Check balance for prepaid
                
                $.ajax({
                    url: '/check-balance',
                    method: 'GET',
                    data: { amount: amount, customer_id: customerId },
                    success: function(response) {
                        if (response.success) {
                            $('#error-message').hide();
                        } else {
                            $('#error-message').text('Insufficient balance.').show();
                        }
                    }
                });
            }

            if (paymentMethod === '4') {
                // Check if the customer is a cash customer
                $.ajax({
                    url: '/check-cash-customer',
                    method: 'GET',
                    data: { customer_id: customerId },
                    success: function(response) {
                        if (response.isCashCustomer) {
                            $('#error-message').hide();
                        } else {
                            $('#error-message').text('Customer is not a cash customer.').show();
                        }
                    }
                });
            }
        });

        
    </script>


<script>
$(document).ready(function() {
    // Function to toggle popup link visibility
    function togglePopupLink() {
        let selectedValue = $("#reqtypeid").val();
        if (selectedValue == "2") {
            $("#openPopup").show();  // Show when option 2 is selected
        } else {
            $("#openPopup").hide();  // Hide for other options
        }
    }

    // Call function when select changes
    $("#reqtypeid").on("change", function() {
        togglePopupLink();
    });

    // Run on page load to handle pre-selected values
    togglePopupLink();
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