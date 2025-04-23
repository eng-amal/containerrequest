@extends('master')

@section('title',  __('contreq.pagename87'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="container mt-4">
    <h2 class="mb-4">{{ __('contreq.pagename87') }}</h2>

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
    <form action="{{ route('purchasestore') }}" method="POST">
        @csrf
        <div class="row flex">
        <div class="w-25 p-3">
            <strong>{{ __('contreq.sanddate') }}</strong>
            <input type="date" name="purchdate" id="purchdate" class="form-control" required>
        </div>
        <div class="w-25 p-3">
            <strong>{{ __('contreq.total') }}</strong>
            <input type="text" name="total" id="total" readonly class="form-control" >
        </div>
        <div class="w-25 p-3" >
                        <strong>{{ __('contreq.saccountid') }}</strong>
                        <select id="faccount" name="faccount" class="form-select" value="{{ old('faccount') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.faccount') }}</option>
                       
                        </select>
                        
                        @error('faccount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" >
                        <strong>{{ __('contreq.saccountid') }}</strong>
                        <select id="daccount" name="daccount" class="form-select" value="{{ old('daccount') }}" class="form-control">
                         <option value="" selected="selected">{{ __('contreq.faccount') }}</option>
                       
                        </select>
                        
                        @error('daccount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
      </div>
        <h4>{{ __('contreq.detail') }}</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('contreq.secclassname') }}</th>
                    <th>{{ __('contreq.quantity') }}</th>
                    <th>{{ __('contreq.price') }}</th>
                    <th>{{ __('contreq.tprice') }}</th>
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
                        <input type="number" name="prices[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" readonly name="tprices[]" class="form-control" >
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
            // Use AJAX to fetch categories
            $.ajax({
                url: '/get-accounts', // The route to fetch data
                method: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#faccount').empty();
                    $('#daccount').empty();
                    // Add a default option
                    $('#faccount').append('<option value="">Select account:</option>');
                    $('#daccount').append('<option value="">Select account:</option>');

                    // Loop through the categories and append them to the select element
                    $.each(response, function(index, account) {
                        $('#faccount').append('<option value="' + account.id + '">' + account.name + '</option>');
                        $('#daccount').append('<option value="' + account.id + '">' + account.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching accounts: ', error);
                }
            });
        });
    </script>
<script>
$(document).ready(function() {
    // إضافة سطر جديد
    $("#add-row").click(function() {
        let newRow = `
            <tr>
                <td>
                    <select name="secclasss[]" class="form-control item-select" required>
                        @foreach ($secclasss as $secclass)
                            <option value="{{ $secclass->id }}" data-balance="{{ $currentBalance }}">{{ $secclass->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantities[]" class="form-control" required>
                </td>
                <td>
                    <input type="number" name="prices[]" class="form-control" required>
                </td>
                <td>
                    <input type="number" name="tprices[]" class="form-control" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">حذف</button>
                </td>
            </tr>`;
        $("#secclasss-table").append(newRow);
    });

    // تحديث السعر الإجمالي عند إدخال الكمية أو السعر
    $(document).on("input", "input[name='quantities[]'], input[name='prices[]']", function() {
        let row = $(this).closest("tr");
        let quantity = parseFloat(row.find("input[name='quantities[]']").val()) || 0;
        let price = parseFloat(row.find("input[name='prices[]']").val()) || 0;
        let totalPrice = quantity * price;
        row.find("input[name='tprices[]']").val(totalPrice.toFixed(2));

        calculateTotal();
    });

    // حذف السطر وإعادة حساب الإجمالي
    $(document).on("click", ".remove-row", function() {
        if ($("#secclasss-table tr").length > 1) {
            $(this).closest("tr").remove();
            calculateTotal(); // تحديث الإجمالي بعد الحذف
        } else {
            alert("يجب أن يحتوي الجدول على صف واحد على الأقل!");
        }
    });

    // حساب الإجمالي النهائي
    function calculateTotal() {
        let total = 0;
        $("input[name='tprices[]']").each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $("#total").val(total.toFixed(2));
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