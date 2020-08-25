@extends('master')

@section('content')

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Uh-oh</h3>
  </div>
  
</div>

<br>

<div class="row">
  <div class="col-lg-12">
    <p>
      {!! isset($query) ? "Shame on you!<br>There is no such thing as $query in Monero's blockchain!" :
        (isset($message) ? $message : "Nothing found.") !!}
    </p>
  </div> <!-- /.col-lg-12 -->
</div> <!-- ./row -->

@endsection
