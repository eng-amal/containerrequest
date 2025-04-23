@extends('master')

@section('title',  __('contreq.pagename84'))

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
<div class="evaluation-container">
    <h2>{{ __('contreq.pagename84') }}</h2>
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
    <form action="{{ route('employee.evaluation.store') }}" method="POST">
        @csrf
        <input type="hidden" name="empid" value="{{ $employeeId }}">
        <input type="hidden" name="temid" value="{{ $evaluationId }}">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>{{ __('contreq.Evaname') }}</th>
                    <th>{{ __('contreq.Evamark') }}</th>
                    <th>{{ __('contreq.ymark') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluationDetails as $detail)
                    <tr>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->mark }}</td>
                        <td>
                        <input type="hidden" name="employee_marks[{{ $loop->index }}][name]" value="{{ $detail->name }}">
                        <input type="hidden" name="employee_marks[{{ $loop->index }}][template_mark]" value="{{ $detail->mark }}">
                        <input type="number" name="employee_marks[{{ $loop->index }}][employee_mark]" required min="0" max="{{ $detail->mark }}">
                        </td>

                    </tr>
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