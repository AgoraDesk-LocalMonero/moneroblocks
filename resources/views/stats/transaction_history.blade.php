@extends('master')

@section('content')

@include('stats.stats_nav')

<a name="block-medians"></a>
<div id="wide-header" class="row">
  <div class="col-xs-12 col-lg-12 text-left">
    <h5><span class="page-header large"><i class="fa fa-star-half-o fa-fw"></i> daily average transactions per block </span></h5>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div>
	<script>
		window['myconf'] = {
		yLabel: "Transactions",
		smoothCurve: false,
		includeZero: false,
		dateFormat: 'DD/MM/YYYY',
		rebase: false,
		valuePrefix: null,
		valueSuffix: 'txs'
	};
	</script>

	<table data-fm-config="myconf" class="data-table fm-line">
		<thead>
			<tr>
				<th>Block</th>
				<th data-fm-color="#0000ff">Transactions</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($transactions as $row)
			<tr>
				<td>{{$row->day }}</td>
				<td>{{$row->average_tx }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

<script defer src="{{ URL::asset('js/line.min.js') }}"></script>

@endsection
