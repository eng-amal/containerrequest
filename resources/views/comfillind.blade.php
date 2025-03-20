@extends('master')
@section('title',  __('contreq.pagename8'))

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename8') }}</h2>
      </div> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.reqdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.mobno') }}</th> 
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($liftreqs as $liftreq)
                    <tr>
                        <td >{{ $liftreq->id }}</td>
                        <td >{{ $liftreq->reqdate }}</td>
                        <td >{{ $liftreq->custname }}</td>
                        <td>{{ $liftreq->mobno }}</td>
                        <td>
                    <!-- Update Button -->
                    <a class="btn" href="{{ route('compfillreq', $liftreq->id) }}"> <img src="{{ asset('images/del.JPG') }}" alt="edit" width="30" height="30"> 
                   </a>
                   
                </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
       
    </div>
    

  </main>

</div>
@endsection