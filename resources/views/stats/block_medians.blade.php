@extends('master')

@section('content')

@include('stats.stats_nav')

<a name="block-medians"></a>
<div id="wide-header" class="row">
  <div class="col-xs-12 col-lg-12 text-left">
    <h5><span class="page-header large"><i class="fa fa-bullseye fa-fw"></i> median block size of the last n blocks </span></h5>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
  <div class="col-xs-12 col-lg-12">
    <div class="panel panel-default panel-table">
      <div class="panel-heading">
        <div class="row ">
          <div class="col-xs-2">100</div>
          <div class="col-xs-2">200</div>
          <div class="col-xs-2">400</div>
          <div class="col-xs-2">600</div>
          <div class="col-xs-2">800</div>
          <div class="col-xs-2">1000</div>
        </div>
      </div>
      <div class="row show-grid top-row">
        <div class="col-xs-2"><?php echo $medians['median100'] ?></div>
        <div class="col-xs-2"><?php echo $medians['median200'] ?></div>
        <div class="col-xs-2"><?php echo $medians['median400'] ?></div>
        <div class="col-xs-2"><?php echo $medians['median600'] ?></div>
        <div class="col-xs-2"><?php echo $medians['median800'] ?></div>
        <div class="col-xs-2"><?php echo $medians['median1000'] ?></div>
      </div>
    </div>
    <!-- /.panel-body -->
  </div>
  <!-- /.panel -->
</div>
<!-- /.row -->
@endsection
