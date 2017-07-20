<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Monero Blocks - XMR block explorer</title>
		<meta name="keywords" content="monero, block, transaction, payment id, blockexplorer, richlist, hashrate, difficulty, explorer, blockchain, xmr">
		<meta name="description" content="Monero blockchain explorer -  XMR blocks, transactions, payment ids, hashrate, emission. We show it all. ">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!--	<link href='//fonts.googleapis.com/css?family=Ubuntu+Mono:400,400italic,700,700italic' rel='stylesheet' type='text/css'> -->

		<link rel="icon" type="image/png" href="{{ URL::asset('img/favico_monero.ico') }}">

		<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/grayscale.css') }}">

	        @if (Route::current()->getPrefix() == '/stats')
		<link rel="stylesheet" href="{{ URL::asset('css/line.min.css') }}">
	        @endif

	</head>
	<body>
		<div id="wrapper">

			<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-default">
						<div class="navbar-header">
							<a href="/" title="Monero blocks - blockchain explorer" class="navbar-brand">
								<div class="pull-left">
									<img src="{{ URL::asset('img/monero-block-explorer.png') }}" alt="Monero block explorer"/>
								</div>
								<span class="light">blocks</span>
							</a>
						</div>
						<ul class="nav navbar-nav">
							<!-- Hidden li included to remove active class from about link when scrolled up past about section -->
							<li class="hidden active"><a href="#page-top"></a></li>
							<li><a class="page-scroll" href="/">Explorer</a></li>
							<li><a class="page-scroll" href="/stats">Stats</a></li>
							<li><a class="page-scroll" href="/richlist">Rich List</a></li>
							<li><a class="page-scroll" href="/api">API</a></li>
						</ul>
						<form id="frmSearch" action="/search/">
							<div class="input-group custom-search-form">
								<input type="text" class="form-control" placeholder="Search by block height / block hash / transaction hash / payment id" id="txt_search">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit" id="btn_search">
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
						</form>
					<!-- /.sidebar-collapse -->
					</div>

				</div>
				<!-- /.container -->
			</nav>

			<div id="page-wrapper">

			@yield('content')

			</div>
		<!-- /#page-wrapper -->
		</div>
		<!-- /#wrapper -->
		<footer>
			<div class="container text-center">
				If you find this useful, please consider contributing.
				<span class="hash single-line">Monero Address: 49Jt4tzbvZ5PyEMub6tNDGKP4zxogN9t1VACVWgTEcMwhtCGjxrDyt5XCDHG6XpA2U1uWsnsyKYdrL25Vp6y2pou2bdboCZ</span>
				<span class="single-line"><a href='https://openalias.org/'>OpenAlias</a>: donate.moneroblocks.info </span>
			</div>
		</footer>
		<script src="{{ URL::asset('js/b2.js') }}"></script>
	</body>
</html>
