@extends('master')

@section('content')

@include('stats.stats_nav')

<a name="block-medians"></a>
<div id="wide-header" class="row">
  <div class="col-xs-12 col-lg-12 text-left">
    <h5><span class="page-header large"><i class="fa fa-star-half-o fa-fw"></i> median & block sizes last 1440 blocks </span></h5>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div>
	<script>
		window['myconf'] = {
		yLabel: "Size (bytes)",
		smoothCurve: false,
		includeZero: false,
		dateFormat: 'DD/MM/YYYY',
		rebase: false,
		valuePrefix: null,
		valueSuffix: 'B'
	};
	</script>

	<table data-fm-config="myconf" class="data-table fm-line">
		<thead>
			<tr>
				<th>Block</th>
				<th data-fm-color="#ff0000">Size</th>
				<th data-fm-color="#0000ff">Median</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($medians as $row)
			<tr>
				<td>{{ $row->height }}</td>
				<td>{{ $row->size }}</td>
				<td>{{ $row->median }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

<script defer src="{{ URL::asset('js/line.min.js') }}"></script>

@endsection
