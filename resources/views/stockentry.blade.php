@extends('master')

@section('title',  __('contreq.pagename81'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="container mt-4">
    <h2 class="mb-4">{{ __('contreq.pagename81') }}</h2>

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
    <form action="{{ route('stockstore') }}" method="POST">
        @csrf
        <div class="row flex">
        <div class="w-25 p-3">
            <strong>{{ __('contreq.stocktype') }}</strong>
            <select class="form-select" name="entrytype" id="entrytype"  required>
                <option value="1">{{ __('contreq.stocktype1') }}</option>
                <option value="2">{{ __('contreq.stocktype2') }}</option>
            </select>
        </div>

        <div class="w-25 p-3">
            <strong>{{ __('contreq.sanddate') }}</strong>
            <input type="date" name="entrydate" id="entrydate" class="form-control" required>
        </div>
</div>
        <h4>{{ __('contreq.detail') }}</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('contreq.secclassname') }}</th>
                    <th>{{ __('contreq.quantity') }}</th>
                    <th>{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody id="secclasss-table">
                <tr>
                    <td>
                        <select name="secclasss[]" class="form-control item-select" required>
                            @foreach ($secclasss as $secclass)
                            @php
                            $stockItem = \App\Models\stock::where('itemid', $secclass->id)->first();
                            $currentBalance = $stockItem ? $stockItem->balance : 0;
                             @endphp
                                <option value="{{ $secclass->id }}" data-balance="{{ $currentBalance }}">{{ $secclass->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantities[]" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">حذف</button>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <button type="button" class="btn btn-primary" id="add-row">{{ __('contreq.add') }}</button>
        <button type="submit" class="btn btn-success">{{ __('contreq.submit') }}</button>
    </form>
</div>

<!-- سكريبت لإضافة وحذف الأسطر -->

@endsection
@section('scripts')
  <!-- Main JS File -->
 
<script>
$(document).ready(function() {
    // عند تغيير الكمية، تحقق من الرصيد إذا كان الإدخال "خروج"
    $(document).on("input", "input[name='quantities[]']", function() {
        let quantity = parseFloat($(this).val()) || 0;
        let row = $(this).closest("tr");
        let selectedItem = row.find(".item-select option:selected");
        let balance = parseFloat(selectedItem.data("balance")) || 0;
        let entryType = $("#entrytype").val(); // Get the entry type

        if (entryType== "2" && quantity > balance) {
            alert(`خطأ: الكمية المطلوبة (${quantity}) أكبر من الرصيد المتاح (${balance})`);
            $(this).val(balance); // Reset to max available balance
        }
    });
    // إضافة سطر جديد
    $("#add-row").click(function() {
        let newRow = `
            <tr>
                <td>
                    <select name="secclasss[]" class="form-control" required>
                        @foreach ($secclasss as $secclass)
                            <option value="{{ $secclass->id }}">{{ $secclass->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantities[]" class="form-control" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">حذف</button>
                </td>
            </tr>`;
        $("#secclasss-table").append(newRow);
    });

    // حذف السطر
    $(document).on("click", ".remove-row", function() {
        $(this).closest("tr").remove();
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