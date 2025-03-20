@extends('master')
@section('title',  __('contreq.pagename46'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename46') }}</h2>
      </div> 
      @if ($message = Session::get('error'))
           <div class="alert alert-danger">
             <p>{{ $message }}</p>
           </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <form method="GET" action="{{ route('sandSearch') }}">
    <div class="row mb-3">
        <div class="col-md-4">
            <label>اسم الحساب</label>
            <select name="account_id" class="form-control">
                <option value="">اختر الحساب</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>من تاريخ</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>إلى تاريخ</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block">بحث</button>
        </div>
    </div>
</form>
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.sanddate') }}</th>
                    <th>{{ __('contreq.type') }}</th>
                    <th>{{ __('contreq.inamount') }}</th>
                    <th>{{ __('contreq.outamount') }}</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach ($sands as $sand)
                    <tr>
                        <td>{{ $sand->id }}</td>
                        <td>{{ $sand->sanddate }}</td>
                        <td>{{ $sand->type_label}}</td>
                        <td>{{ number_format($sand->debit_amount, 2) }}</td>
                        <td> {{ number_format($sand->credit_amount, 2) }}</td>
                        
                    </tr>
                    @endforeach
            </tbody>
        </table>
      
    </div>
    </section><!-- /Starter Section Section -->

  </main>
</div>
@endsection
