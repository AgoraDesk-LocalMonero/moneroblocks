@extends('master')

@section('content')

@include('explorer.network_stats')

@include('explorer.transaction_pool')

	<div class="row">
      <div class="col-xs-12 col-lg-12">
        <h3 class="page-header"><i class="fa fa-chain fa-fw"></i> Latest blocks</h3>
				@if ($higher > 0)
       	<span class="pull-left">
      		<a href="{{ url('browser', $higher) }}">
						<i class="fa fa-chevron-left fa-1x"></i>&nbsp;Higher
					</a>
       	</span>
				@endif

				@if ($lower > 0)
       	<span class="pull-right">
      		<a href="{{ url('browser', $lower) }}">
						&nbsp;Lower<i class="fa fa-chevron-right fa-1x"></i>
					</a>
       	</span>
				@endif
				
      </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- /.col-lg-8 -->
      <div class="col-xs-12 col-lg-12">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <div class="row ">
              <div class="col-xs-3 col-sm-1 col-md-1 first-column">Height</div>
              <div class="col-xs-2 col-sm-1 col-md-1">Size</div>
              <div class="col-xs-2 col-sm-1 col-md-1">Tx</div>
              <div class="col-xs-5 col-sm-3 col-md-2">Timestamp</div>
              <div class="col-xs-12 col-sm-6 col-md-2 hash-header" >Block Hash</div>
            </div>
          </div>
          <!-- /.panel-heading -->

          <div class="panel-body">
         @foreach ($block_list as $block)
            <div class="row show-grid top-row">
              <a href="{{ url('block', $block->height) }}"></a>
              <div class="col-xs-3 col-sm-1 col-md-1"><strong class="primary-font">{{ $block->height }}</strong></div>
              <div class="col-xs-2 col-sm-1 col-md-1">{{ $block->size }}</div>
              <div class="col-xs-2 col-sm-1 col-md-1">{{ $block->tx_count }}</div>
              <div class="col-xs-5 col-sm-3 col-md-2">@datetime($block->timestamp)</div>
              <div class="col-xs-12 col-sm-6 col-md-7 hash">{{ $block->hash }}</div>
           </div>     
         @endforeach
          </div>
          <!-- /.panel-body -->
        </div>
         <!-- /.panel -->
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->

@endsection
