
@extends('master')
@section('title',  __('contreq.pagename15'))

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
                    <h2 class="text-color">{{ __('contreq.pagename15') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('invoiceindex', $contract->id) }}"> {{ __('contreq.back') }}</a>
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
        <form action="{{ route('storeinvoice') }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
            @csrf
            <input type="hidden" name="contractid" value="{{ $contract->id }}">
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.total') }}</strong>
                        <input type="text" requerid name="total" id="total" value="{{ old('total') }}" id="total" class="form-control" placeholder="{{ __('contreq.total') }}">
                        @error('total')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>

                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.ispay') }}</strong>
                        <select id="ispay" class="form-select" name="ispay" value="{{ old('ispay') }}" >
                        <option value="1" {{ old('ispay') == 1 ? 'selected' : '' }}>{{ __('contreq.ispay1') }}</option>
                        <option value="2" {{ old('ispay') == 2 ? 'selected' : '' }}>{{ __('contreq.ispay2') }}</option>

                        </select>
                        
                        @error('ispay')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.paytype') }}</strong>
                        <select id="paytypeid" class="form-select" name="paytypeid" value="{{ old('paytypeid') }}" >
                        <option value="" {{ old('paytypeid') == '' ? 'selected' : '' }}>{{ __('contreq.paytype') }}</option>
                        <option value="1" {{ old('paytypeid') == 1 ? 'selected' : '' }}>{{ __('contreq.paytypeid1') }}</option>
                        <option value="2" {{ old('paytypeid') == 2 ? 'selected' : '' }}>{{ __('contreq.paytypeid2') }}</option>

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
                   <div class="row flex">
                    <div class="w-25 p-3">
                    <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div></div>
            <!-- </div> -->
        </form>
    </div>
    </div><!-- /Starter Section Section -->

  </main>
</div>
@endsection
@section('scripts')
  <!-- Main JS File -->
  <script>
        $(document).ready(function() {
            var paymentMethod = $('#paytypeid').val();
            var ispayValue = $('#ispay').val();
            if (ispayValue == '2') {
            if (paymentMethod === '2')
             {
                
                $('#bankdiv').show();
                $('#transferdiv').show();
                
             }
             else
             {
                
                $('#bankdiv').hide();
                $('#transferdiv').hide();
             }
            }
            else
            {
                $('#bankdiv').hide();
                $('#transferdiv').hide();
            }

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
        $('#paytypeid').change(function() {
            
            var paymentMethod = $(this).val();
            var ispayValue = $('#ispay').val();
            if (ispayValue == '2') {
            if (paymentMethod === '2')
             {
                
                $('#bankdiv').show();
                $('#transferdiv').show();
                
             }
             else
             {
                
                $('#bankdiv').hide();
                $('#transferdiv').hide();
             }
            }
            else
            {
                $('#bankdiv').hide();
                $('#transferdiv').hide();
            }
             
           
        });

        
    </script>
<script>
        $('#ispay').change(function() {
            
            var ispayValue = $(this).val();
            
            if (ispayValue === '1') {
            
                $('#bankdiv').hide();
                $('#transferdiv').hide();
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