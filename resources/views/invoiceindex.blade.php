@extends('master')
@section('title',  __('contreq.pagename16'))
@section('head')
<style>
.priority-1 {
  background-color:rgb(238, 171, 171) !important; /* Color for priority 1 (light red) */
  box-shadow: 0px 2px 5px rgba(255, 0, 0, 0.3);
}
</style>
@endsection

@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<main class="main">
<!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename16') }}</h2>
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
                    <th>{{ __('contreq.invoicedate') }}</th>
                    <th>{{ __('contreq.total') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr class="
                    @if($invoice->ispay == 1) priority-1
                    @endif">
                        <td class="
                    @if($invoice->ispay == 1) priority-1
                    @endif">{{ $invoice->id }}</td>
                        <td class="
                    @if($invoice->ispay == 1) priority-1
                    @endif">{{ $invoice->invoicedate }}</td>
                        <td class="
                    @if($invoice->ispay == 1) priority-1
                    @endif">{{ $invoice->total }}</td>
                        
                        <td>
                            <form action="{{ route('destroyinvoice',$invoice->id) }}" method="Post">
                                <a class="btn" href="{{ route('invoiceedit',$invoice->id) }}">
                                <img src="{{ asset('images/del.JPG') }}" alt="edit" width="30" height="30"> 
                                </a>
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
        {!! $invoices->links() !!}
    </div>
    </section><!-- /Starter Section Section -->

  </main>
</div>
@endsection
