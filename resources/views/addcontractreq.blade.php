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
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('contractindex') }}"> {{ __('contreq.back') }}</a>
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
        
        <form action="{{ route('storecontactreq') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input id="reqid" name="reqid" hidden value="{{ old('reqid') }}">
            <input type="hidden" name="contractid" value="{{ $contract->id }}">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.reqdate') }}</strong>
                        <input type="datetime-local" name="reqdate" value="{{ old('contractdate') }}" class="form-control"  placeholder="requestdate">
                        @error('reqdate')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input type="text" name="custname" readonly value="{{ $contract->custname }}" class="form-control" placeholder="{{ __('contreq.custname') }}">
                        @error('custname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobno" readonly value="{{ $contract->mobileno }}" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input type="text" name="whatno" readonly value="{{ $contract->whatno }}" reaonly class="form-control" placeholder="{{ __('contreq.whatno') }}">
                        @error('whatno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contsizeid') }}</strong>
                        <select id="contsizeid" name="contsizeid" class="form-select">
                         <option value="">{{ __('contreq.contsizeid') }}</option>
                          @foreach ($containersizes as $cont)
                          <option value="{{ $cont->id }}" {{ $contract->contsizeid == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('contsizeid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.contid') }}</strong>
                        <select id="contid" name="contid" class="form-select">
                         <option value="">{{ __('contreq.contid') }}</option>
                          
                        </select>
                        
                        @error('contid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
              
                   
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.city') }}</strong>
                        <select id="cityid" name="cityid" class="form-select">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($citys as $city)
                          <option value="{{ $city->id }}" {{ $contract->cityid == $city->id ? 'selected' : '' }}>
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
                        <select id="streetid" name="streetid" class="form-select">
                         <option value="">{{ __('contreq.city') }}</option>
                          @foreach ($streets as $street)
                          <option value="{{ $street->id }}" {{ $contract->streetid == $street->id ? 'selected' : '' }}>
                        {{ $street->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('streetid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
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
                    <a href="{{ $contract->location }}" target="_blank">{{ __('contreq.location_url') }}</a></div>
                    <div class="w-50 p-3">
                        <input  readonly type="text" name="contlocation" value="{{ $contract->location }}" class="form-control"  placeholder="Paste Google Maps Location URL here">
                        @error('contlocation')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.empid') }}</strong>
                        <select id="empid" name="empid" class="form-select">
                         <option value="">{{ __('contreq.empid') }}</option>
                         
                        </select>
                        @error('empid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="row flex">
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.fromdate') }}</strong>
                        <input type="datetime-local" name="fromdate" value="{{ old('fromdate') }}" class="form-control" placeholder="fromdate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.todate') }}</strong>
                        <input type="datetime-local" name="todate" value="{{ old('todate') }}" class="form-control" placeholder="todate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                    <div class="w-25 p-3">
                <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div>
            
        </form>
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
    </div>

   

  </main>
 </div>
  @endsection
  @section('scripts')
 
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
$(document).ready(function () {
    // Open popup and load data
    $("#openPopup").click(function () {
        $.ajax({
            url: "{{ route('getContactRequests') }}",
            method: "GET",
            data: { contractid: $("input[name='contractid']").val() },
            success: function (data) {
                console.log("AJAX Response:", data);
                let tableContent = "";
                if (data.length === 0) {
                    tableContent = `<tr><td colspan="4" class="text-center">No requests found</td></tr>`;
                } else {
                    $.each(data, function (index, request) {
                        tableContent += `<tr data-custname="${request.custname}" data-mobno="${request.mobno}" 
                                            data-whatno="${request.whatno}" data-reqid="${request.id}" 
                                            data-cost="${request.cost}" data-loc="${request.contlocation}" 
                                            data-cityid="${request.cityid}" data-streetid="${request.streetid}" 
                                            data-contsizeid="${request.contsizeid}">
                                            <td>${request.custname}</td>
                                            <td>${request.mobno}</td>
                                            <td>${request.reqdate}</td>
                                            <td><button class="btn btn-success select-request">Select</button></td>
                                        </tr>`;
                    });
                }
                $("#requestTable").html(tableContent);
                $("#requestModal").modal("show");
            }, // ✅ Fixed missing closing brace here
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        }); // ✅ Fixed missing closing brace here
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
        $("#reqid").val(row.data("reqid"));
        $("#requestModal").modal("hide"); // Close the modal after selection
    });
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
$(document).ready(function(){
    // When the first dropdown changes
    
        var selectedValue = $('#contsizeid').val(); // Get the selected value from first dropdown
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
@endsection
  