@extends('master')
@section('title',  __('contreq.pagename6'))
@section('head')
<style>
.priority-1 {
  background-color:rgb(238, 171, 171) !important; /* Color for priority 1 (light red) */
  
  box-shadow: 0px 2px 5px rgba(255, 0, 0, 0.3);
}
.priority-2 {
  background-color:rgb(242, 242, 24) !important; /* Color for priority 2 (light yellow) */
  box-shadow: 0px 2px 5px rgba(255, 255, 0, 0.3); 
}
.priority-3 {
  background-color:rgb(108, 230, 108) !important; /* Color for priority 3 (light green) */
  box-shadow: 0px 2px 5px rgba(0, 255, 0, 0.3);
}
.future-request1 {
  border: 2px solid #007bff; /* Blue border for future requests */
  box-shadow: 0px 2px 5px rgba(22, 26, 240, 0.3);
 
}
</style>
@endsection
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">
      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename6') }}</h2>
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
                    <tr class="
                    @if($liftreq->liftprorityid == 1) priority-1
                    @elseif($liftreq->liftprorityid == 2) priority-2
                    @elseif($liftreq->liftprorityid == 3) priority-3
                    @endif
                    {{ \Carbon\Carbon::parse($liftreq->liftdate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($liftreq->liftdate)->isToday() ? 'future-request1' : '' }} 
                    ">
                        <td  class="
                    @if($liftreq->liftprorityid == 1) priority-1
                    @elseif($liftreq->liftprorityid == 2) priority-2
                    @elseif($liftreq->liftprorityid == 3) priority-3
                    @endif
                    {{ \Carbon\Carbon::parse($liftreq->liftdate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($liftreq->liftdate)->isToday() ? 'future-request1' : '' }} 
                    ">{{ $liftreq->id }}</td>
                        <td class="
                    @if($liftreq->liftprorityid == 1) priority-1
                    @elseif($liftreq->liftprorityid == 2) priority-2
                    @elseif($liftreq->liftprorityid == 3) priority-3
                    @endif
                    {{ \Carbon\Carbon::parse($liftreq->liftdate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($liftreq->liftdate)->isToday() ? 'future-request1' : '' }} 
                    ">{{ $liftreq->reqdate }}</td>
                        <td class="
                    @if($liftreq->liftprorityid == 1) priority-1
                    @elseif($liftreq->liftprorityid == 2) priority-2
                    @elseif($liftreq->liftprorityid == 3) priority-3
                    @endif
                    {{ \Carbon\Carbon::parse($liftreq->liftdate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($liftreq->liftdate)->isToday() ? 'future-request1' : '' }} 
                    ">{{ $liftreq->custname }}</td>
                        <td class="
                    @if($liftreq->liftprorityid == 1) priority-1
                    @elseif($liftreq->liftprorityid == 2) priority-2
                    @elseif($liftreq->liftprorityid == 3) priority-3
                    @endif
                    {{ \Carbon\Carbon::parse($liftreq->liftdate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($liftreq->liftdate)->isToday() ? 'future-request1' : '' }} 
                    ">{{ $liftreq->mobno }}</td>
                        <td>
                    <!-- Update Button -->
                    <a class="btn" href="{{ route('editfill', $liftreq->id) }}"> <img src="{{ asset('images/del.JPG') }}" alt="edit" width="30" height="30"> 
                   </a>
                   <a class="btn " href="{{ url('/send/' . $liftreq->id) }}">
                               <img class="
                    @if($liftreq->liftprorityid == 1) priority-1
                    @elseif($liftreq->liftprorityid == 2) priority-2
                    @elseif($liftreq->liftprorityid == 3) priority-3
                    @endif
                    {{ \Carbon\Carbon::parse($liftreq->liftdate)->isBefore(\Carbon\Carbon::now()) || \Carbon\Carbon::parse($liftreq->liftdate)->isToday() ? 'future-request1' : '' }} 
                    " src="{{ asset('images/send.JPG') }}" alt="send to driver" width="30" height="30">
                              </a>
                    <!-- Delete Button -->
                    <form action="{{ route('destroyfill', $liftreq->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn">
                        <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="30" height="30"> 
                        </button>
                    </form>
                </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
       
    </div>
    

  </main>

</div>
@endsection