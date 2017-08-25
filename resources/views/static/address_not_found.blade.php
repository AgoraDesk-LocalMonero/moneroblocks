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
      For a moment there it seemed that you were trying to peek into this Monero address:<br/>
      <span class="tiny">{{ $query }}</span><br/>
      No?
    </p>
    <p>
      Hmmm... it really looks like you were, like, trying to check out this dude's balance.
    </p>
    <p>
      Well, 
    </p>  
    <span class="huge">
      <a href="https://getmonero.org/knowledge-base/about">Monero says 'No'! </a>
    </span>
  </div> <!-- /.col-lg-12 -->
</div> <!-- ./row -->

@endsection
