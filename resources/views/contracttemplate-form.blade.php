@extends('master')

@section('title',  __('contreq.pagename86'))

@section('head')
<style>
    /* Container styling */
    .evaluation-container {
        max-width: 800px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Table styling */
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }

    .styled-table th, .styled-table td {
        padding: 12px;
        border: 1px solid #ddd;
    }

    .styled-table thead {
        background-color: #007bff;
        color: white;
    }

    /* Input styling */
    input[type="number"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    /* Button styling */
    .submit-btn {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .submit-btn:hover {
        background-color: #218838;
    }
</style>
@endsection

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="evaluation-container">
    <h2>{{ __('contreq.pagename86') }}</h2>
<!-- رسالة نجاح -->
@if ($message = Session::get('success'))
        <div class="alert alert-success">
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
    <form action="{{ route('storecontractform') }}" method="POST"  id="contractForm">
        @csrf
        <input type="hidden" name="contracttemid" value="{{ $contracttemplateId }}">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>{{ __('contreq.Evaname') }}</th>
                    <th>{{ __('contreq.condescr') }}</th>
                    <th>{{ __('contreq.rank') }}</th>
                    <th>{{ __('contreq.value') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracttemplateDetails as $detail)
                    <tr>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->descr }}</td>
                        <td>{{ $detail->rank }}</td>
                        <td>
                            <input type="text" name="employee_marks[{{ $loop->index }}][val]" value="{{ $detail->val }}">
                        </td>
                       

                    </tr>
                    <input type="hidden" name="employee_marks[{{ $loop->index }}][name]" value="{{ $detail->name }}">
                        <input type="hidden" name="employee_marks[{{ $loop->index }}][descr]" value="{{ $detail->descr }}">
                        <input type="hidden" name="employee_marks[{{ $loop->index }}][rank]" value="{{ $detail->rank }}">
                       
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="submit-btn">{{ __('contreq.submit') }}</button>
    </form>
</div>
@endsection

@section('scripts')
  <!-- Main JS File -->
  <script>
    // Listen for form submission
    document.getElementById('contractForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the default form submission

        // Perform the form submission using AJAX (or fetch API) to avoid reloading the page
        var formData = new FormData(this);

        fetch("{{ route('storecontractform') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",  // Add CSRF token for security
            }
        })
        .then(response => response.json())  // Handle JSON response
        .then(data => {
            // If the form was successfully submitted
            if (data.success) {
                // Open the report URL in a popup window
                var reportUrl = data.reportUrl; // The report URL sent from the controller
                var popupWindow = window.open(reportUrl, 'Contract Report', 'width=800,height=600');
                // Optionally you can close the current form or reset it
                document.getElementById('contractForm').reset();

                // Redirect to the homepage after 2 seconds (if needed)
                setTimeout(function() {
                    window.location.href = "{{ route('home') }}";  // Redirect to the homepage
                }, 2000);  // Wait 2 seconds to let the popup open
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            alert('Error submitting form: ' + error);
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