
@extends('master')
@section('title',  __('contreq.pagename90'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
      <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename90') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ url('/home') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('storecomplamint') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
                    <div class="w-25 p-3">   
                     <a href="#" id="openPopup" class="btn btn-primary">Select Request</a>
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.id') }}</strong>
                        <input id="text" name="reqid" id="reqid" value="{{ old('reqid') }}" class="form-control" readonly placeholder="id">
                        @error('reqid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input id="text" name="custname" id="custname" readonly value="{{ old('custname') }}" class="form-control" placeholder="{{ __('contreq.custname') }}">
                        @error('custname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input id="text" name="mobno" id="mobno" readonly value="{{ old('mobno') }}" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.comstatusid') }}</strong>
                        <select id="comstatusid" class="form-select" name="comstatusid" value="{{ old('comstatusid') }}" >
                        <option value="" {{ old('comstatusid') == '' ? 'selected' : '' }}>{{ __('contreq.comstatusid') }}</option>
                        <option value="1" {{ old('comstatusid') == 1 ? 'selected' : '' }}>{{ __('contreq.comstatusid1') }}</option>
                        <option value="2" {{ old('comstatusid') == 2 ? 'selected' : '' }}>{{ __('contreq.comstatusid2') }}</option>
                         <option value="3" {{ old('comstatusid') == 3 ? 'selected' : '' }}>{{ __('contreq.comstatusid3') }}</option>
                        </select>
                        
                        @error('comstatusid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.comreasonid') }}</strong>
                        <select id="comreasonid" class="form-select" name="comreasonid" value="{{ old('comreasonid') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.account') }}</option>
                         
                        </select>
                        
                        @error('comreasonid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.descr') }}</strong>
                        <input id="text" name="descr" id="descr" required value="{{ old('descr') }}" class="form-control" placeholder="{{ __('contreq.descr') }}">
                        @error('descr')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-25 p-3">
                <button id="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
            
        </form>
    </div>
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestModalLabel">Select Request</h5>
        <button id="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input id="text" id="searchInput" class="form-control mb-2" placeholder="Search by Name or Mobile">

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Customer Name</th>
              <th>Mobile No</th>
              <th>Request Date</th>
              <th>Container No</th>
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

   

  </main>
</div>
@endsection
@section('scripts')
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
                    tableContent += `<tr data-custname="${request.custname}" data-mobno="${request.mobno}" data-whatno="${request.whatno}" data-reqid="${request.id}" data-cost="${request.cost}" data-loc="${request.dcontlocation}" data-cityid="${request.cityid}" data-streetid="${request.streetid}" data-contsizeid="${request.contsizeid}" data-contid="${request.contid}">
                                        <td>${request.custname}</td>
                                        <td>${request.mobno}</td>
                                        <td>${request.reqdate}</td>
                                        <td>${request.conno}</td>
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
        let selectedcont = row.data("contid");
        let selectedContId = row.data("contsizeid");
        let locationUrl = row.data("loc"); // Get the location URL
        $("#custname").val(row.data("custname"));
        $("#mobno").val(row.data("mobno"));
        $("#whatno").val(row.data("whatno"));
        $("#reqid").val(row.data("reqid"));
        $("#cost").val(row.data("cost"));
        $("#contlocation").val(row.data("loc"));
        $("#locurl").attr("href", locationUrl); // Update link text
        if ($("#cityid option[value='" + selectedCityId + "']").length > 0) {
        $("#cityid").val(selectedCityId).trigger("change"); // Trigger change event to update UI if needed
    }
    
    if ($("#contsizeid option[value='" + selectedContId + "']").length > 0) {
        $("#contsizeid").val(selectedContId).trigger("change"); // Trigger change event to update UI if needed
    }
    
        $("#requestModal").modal("hide");
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
            langInput.id = 'hidden';
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
                url: '/get-complamintreasons', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#comreasonid').empty();
                    // Add a default option
                    $('#comreasonid').append('<option value="">Select a reason</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, department) {
                        $('#comreasonid').append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories: ', error);
                }
            });
        });
    </script>
@endsection