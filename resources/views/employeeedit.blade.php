@extends('master')
@section('title',  __('contreq.pagename25'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>{{ __('contreq.pagename25') }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('employeeindex') }}"> {{ __('contreq.back') }}</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('employeeupdate',$employee->id) }}" method="POST" enctype="multipart/form-data" class="form-group p-3 flex row">
        @csrf
        @method('POST')
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.name') }}</strong>
                        <input type="text" name="fullname" value="{{ $employee->fullname }}" class="form-control" readonly placeholder="requestdate">
                        @error('fullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.enname') }}</strong>
                        <input type="text" name="enfullname" readonly value="{{ $employee->enfullname }}" class="form-control" placeholder="{{ __('contreq.enname') }}">
                        @error('enfullname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
               
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mobno') }}</strong>
                        <input type="text" name="mobileno" readonly value="{{ $employee->mobileno }}" class="form-control" placeholder="{{ __('contreq.mobno') }}">
                        @error('mobileno')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex">
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.birthdate') }}</strong>
                        <input type="date" name="birthdate" value="{{ $employee->birthdate }}" class="form-control" placeholder="birthdate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.hiredate') }}</strong>
                        <input type="date" name="hiredate" value="{{ $employee->hiredate }}" class="form-control" placeholder="hiredate">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>
                 <div class="w-25 p-3">
                        <strong>{{ __('contreq.address') }}</strong>
                        <input type="text" name="address" value="{{ $employee->address }}" class="form-control" placeholder="{{ __('contreq.address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.mainsal') }}</strong>
                        <input type="text" name="mainsal" value="{{ $employee->mainsal }}" class="form-control" placeholder="{{ __('contreq.mainsal') }}">
                        @error('mainsal')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>                
                    <div class="w-50 p-3">
                        <strong>{{ __('contreq.empimg') }}</strong>
                        <input type="file" name="empimg" value="{{ $employee->empimg }}" class="form-control" placeholder="{{ __('contreq.empimg') }}">
                        @error('empimg')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.department') }}</strong>
                        <select id="department_id" name="department_id" class="form-select">
                         <option value="">{{ __('contreq.department') }}</option>
                          @foreach ($departments as $cont)
                          <option value="{{ $cont->id }}" {{ $employee->department_id == $cont->id ? 'selected' : '' }}>
                        {{ $cont->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('department')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.position') }}</strong>
                        <select id="positionid" name="positionid" class="form-select">
                         <option value="">{{ __('contreq.position') }}</option>
                          @foreach ($positions as $position)
                          <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}
                          </option>
                         @endforeach
                        </select>
                        
                        @error('positionid')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    
                    
                
                    
                    <div class="w-25 p-3">
                        <strong>{{ __('contreq.nationality') }}</strong>
                        <select id="nationality" name="nationality" class="form-select">
                         <option value="">{{ __('contreq.nationality') }}</option>
                          @foreach ($nationalitys as $nationality)
                          <option value="{{ $nationality->id }}" {{ $employee->nationality == $nationality->id ? 'selected' : '' }}>
                        {{ $nationality->name }}
                          </option>
                         @endforeach
                        </select>
                        @error('nationality')
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
  