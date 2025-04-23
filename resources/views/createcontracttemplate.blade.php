@extends('master')

@section('title',  __('contreq.pagename85'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="container mt-4">
    <h2 class="mb-4">{{ __('contreq.pagename85') }}</h2>

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
    <!-- فورم إدخال البيانات -->
    <form action="{{ route('contracttemplatestore') }}" method="POST">
        @csrf
        <div class="row flex">
        
        <div class="w-25 p-3">
            <strong>{{ __('contreq.temname') }}</strong>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
       </div>
        <h4>{{ __('contreq.detail') }}</h4>
        <table class="table table-bordered" id="evaluationTable">
            <thead>
                <tr>
                    <th>{{ __('contreq.conname') }}</th>
                    <th>{{ __('contreq.condescr') }}</th>
                    <th>{{ __('contreq.rank') }}</th>
                    <th>{{ __('contreq.value') }}</th>
                    <th>{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody >
 <!-- Default Row 1: Team 1 -->
 <tr>
                    <td><input type="text" name="contracttems[0][name]" value="فريق1" class="form-control" required></td>
                    <td><input type="text" name="contracttems[0][descr]" value="فريق 1" class="form-control" required></td>
                    <td><input type="number" name="contracttems[0][rank]" value="1" class="form-control" required></td>
                    <td><input type="text" name="contracttems[0][val]" class="form-control"></td>
                    <td></td> <!-- No delete button for default rows -->
                </tr>

                <!-- Default Row 2: Team 2 -->
                <tr>
                    <td><input type="text" name="contracttems[1][name]" value="فريق 2" class="form-control" required></td>
                    <td><input type="text" name="contracttems[1][descr]" value="فريق 2" class="form-control" required></td>
                    <td><input type="number" name="contracttems[1][rank]" value="2" class="form-control" required></td>
                    <td><input type="text" name="contracttems[1][val]" class="form-control"></td>
                    <td></td> <!-- No delete button for default rows -->
                </tr>

            </tbody>
        </table>
        
        <button type="button" class="btn btn-primary" onclick="addRow()">{{ __('contreq.add') }}</button>
        <button type="submit" class="btn btn-success">{{ __('contreq.submit') }}</button>
    </form>
</div>

<!-- سكريبت لإضافة وحذف الأسطر -->

@endsection
@section('scripts')
  <!-- Main JS File -->
  <script>
   function addRow() {
    const tableBody = document.querySelector("#evaluationTable tbody");
    const rowCount = tableBody.rows.length; // Get the number of existing rows
    const row = document.createElement("tr");

    row.innerHTML = `
        <td><input type="text" name="contracttems[${rowCount}][name]" class="form-control" required></td>
        <td><input type="text" name="contracttems[${rowCount}][descr]" class="form-control" required></td>
        <td><input type="number" name="contracttems[${rowCount}][rank]" class="form-control mark-input" required ></td>
        <td><input type="text" name="contracttems[${rowCount}][val]" class="form-control"  ></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button></td>
    `;

    tableBody.appendChild(row);
    
}

    function removeRow(button) {
        button.closest("tr").remove();
        
    }

    
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