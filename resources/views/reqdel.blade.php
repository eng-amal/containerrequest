@extends('master')
@section('title',  __('contreq.pagename2'))
@section('content')
<div class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <main class="main">

    

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      

      <div class="container mt-2">
      <div class="pull-left mb-2">
        <h2 class="text-color">{{ __('contreq.pagename2') }}</h2>
      </div>  
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                <th>{{ __('contreq.Id') }}</th>
                    <th>{{ __('contreq.reqdate') }}</th>
                    <th>{{ __('contreq.custname') }}</th>
                    <th>{{ __('contreq.mobno') }}</th>
                    <th width="280px">{{ __('contreq.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($containerrequests as $containerrequest)
                    <tr>
                        <td>{{ $containerrequest->id }}</td>
                        <td>{{ $containerrequest->reqdate }}</td>
                        <td>{{ $containerrequest->custname }}</td>
                        <td>{{ $containerrequest->mobno }}</td>
                        
                        <td>
                        <form action="{{ route('containerrequests.delete', $containerrequest->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn"> <img src="{{ asset('images/del1.JPG') }}" alt="Delete" width="30" height="30"></button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $containerrequests->links() !!}
    </div>
    </section><!-- /Starter Section Section -->

  </main>
</div>
@endsection