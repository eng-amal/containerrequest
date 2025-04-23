@extends('master')
@section('title',  __('contreq.pagename47'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename47') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('customerindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('customerupdate',$customer->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
        @csrf
        @method('POST')
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.custname') }}</strong>
                        <input type="text" name="fullname"  value="{{ $customer->fullname }}" class="form-control" placeholder="{{ __('contreq.fullname') }}">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="phone"  value="{{ $customer->phone }}" class="form-control" placeholder="{{ __('contreq.phone') }}">
                        @error('phone')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.whatno') }}</strong>
                        <input type="text" name="whatappno"  value="{{ $customer->whatappno }}" class="form-control" placeholder="{{ __('contreq.whatappno') }}">
                        @error('whatappno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.searchno4') }}</strong>
                        <select id="status" class="form-select" name="status" onchange="toggleBalanceField()" value="{{ old('status') }}" >
                        <option value="0" {{ $customer->status == 0 ? 'selected' : '' }}>{{ __('contreq.status1') }}</option>
                        <option value="1" {{ $customer->status == 1 ? 'selected' : '' }}>{{ __('contreq.status2') }}</option>
                        <option value="2" {{ $customer->status == 2 ? 'selected' : '' }}>{{ __('contreq.status3') }}</option>
                        <option value="3" {{ $customer->status == 3 ? 'selected' : '' }}>{{ __('contreq.status4') }}</option>
                        </select>
                        
                        @error('status')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3" id="baldiv" name="baldiv" style="display: none;">
                        <strong>{{ __('contreq.balance') }}</strong>
                        <input type="text" name="balance"  value="{{ $customer->balance }}" class="form-control" placeholder="{{ __('contreq.balance') }}">
                        @error('balance')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.account') }}</strong>
                        <select id="accountid" name="accountid" class="form-select">
                         <option value="">{{ __('contreq.account') }}</option>
                          @foreach ($accounts as $account)
                          <option value="{{ $account->id }}" {{ $customer->accountid == $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('accountid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="w-25 p-3">
                <button type="submit" class="btn btn-outline-primary">{{ __('contreq.submit') }}</button></div>
            
        </form>
    </div>

   

  </main>
 </div>
  @endsection
  @section('scripts')
 
 
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
<script>
    function toggleBalanceField() {
        let status = document.getElementById("status").value;
        let balanceDiv = document.getElementById("baldiv");

        if (status == 1) {
            balanceDiv.style.display = "block";
        } else {
            balanceDiv.style.display = "none";
        }
    }

    // Run on page load in case status was pre-selected
    document.addEventListener("DOMContentLoaded", toggleBalanceField);
</script>
@endsection
  