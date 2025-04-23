@extends('master')  <!-- Extend a common layout -->

@section('title', __('contreq.evaluationResults'))  <!-- Set the page title -->

@section('head')
    <style>
        /* Container styling */
        .evaluation-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Select box styling */
        .styled-select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Table styling */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            background: #fff;
            text-align: left;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .styled-table th, .styled-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .styled-table thead {
            background-color: #007bff;
            color: white;
        }

        .styled-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .styled-table th, .styled-table td {
                padding: 8px;
            }
        }
    </style>
@endsection

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="evaluation-container">
        <h2>{{ __('contreq.evaluationResults') }}</h2>
        
        <!-- Evaluation Selection Form -->
        <form id="evaluationForm">
            <select name="evaluationId" id="evaluationSelect" class="styled-select">
                <option value="">{{ __('contreq.Evaname') }}</option>
                @foreach($evaluations as $evaluation)
                    <option value="{{ $evaluation->id }}">{{ $evaluation->temname }}</option>
                @endforeach
            </select>
        </form>
        <button id="generateReportBtn" class="btn btn-primary">Generate Report</button>
        <!-- Evaluation Results Table -->
        <div id="evaluationResults">
            <!-- Table will be populated here -->
            @include('partials.evaluation_table', ['employees' => $employees])
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $(document).ready(function() {
            // When an evaluation is selected, fetch the corresponding results
            $('#evaluationSelect').on('change', function() {
                var evaluationId = $(this).val();

                // If evaluationId is not empty, send an AJAX request
                if (evaluationId) {
                    $.ajax({
                        url: "{{ url('/evaluation/results') }}/" + evaluationId,
                        type: "GET",
                        success: function(data) {
                            // Populate the table with the new results
                            $('#evaluationResults').html(data);
                        }
                    });
                } else {
                    // If no evaluation is selected, clear the table
                    $('#evaluationResults').html('');
                }
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        // When the "Generate Report" button is clicked
        $('#generateReportBtn').on('click', function() {
            var evaluationId = $('#evaluationSelect').val();

            // If an evaluation is selected, send an AJAX request to generate the report
            if (evaluationId) {
                window.open("{{ url('/evaluation/report') }}/" + evaluationId, "_blank");
            } else {
                alert("Please select an evaluation.");
            }
        });
    });
</script>
@endsection
