<?php

namespace App\Http\Controllers;

use DB;
use PDO;

class StatsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    //
  public function index()
  {
    
//    $ring_size = [];
//    $txs = []; 
//		$ringct = [];
    
//    $number_of_days = 1; //last day
//    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
//    $tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
//		array_push($ring_size, $m[0]);
//    array_push($txs, $tx[0]);
    
//    $number_of_days = 7; //last week
//    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
//    $tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
//    array_push($ring_size, $m[0]);
//    array_push($txs, $tx[0]);
    
//    $number_of_days = 30; //last month
//    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
//    $tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
//    array_push($ring_size, $m[0]);
//    array_push($txs, $tx[0]);
    
//    $number_of_days = 365; //last year
//    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
//    $tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
//    array_push($ring_size, $m[0]);
//    array_push($txs, $tx[0]);
    
    /* Median Stats */
    
//    DB::setFetchMode(PDO::FETCH_ASSOC);
//		$result = DB::select("SELECT height, size FROM blocks order by height desc limit 1000;");

//		$rs = array_column($result, "size");

//		$arr200 = array_slice($rs,0,200);
//		$arr400 = array_slice($rs,0,400);
//		$arr600 = array_slice($rs,0,600);
//		$arr800 = array_slice($rs,0,800);

//		$medians["median200"] = $this->calculateMedian($arr200);
//		$medians["median400"] = $this->calculateMedian($arr400);
//		$medians["median600"] = $this->calculateMedian($arr600);
//		$medians["median800"] = $this->calculateMedian($arr800);
//		$medians["median1000"] = $this->calculateMedian($rs);
    
//		$growth = DB::select("SELECT * FROM vw_blockchain_size_by_month order by month;");
/*		
		$ct = DB::select("SELECT data, hora, txv1, txv2, txv2/total as ratio FROM vwRingCTTxCountByHour order by data desc, hora desc limit 24;");
		array_push($ringct, $ct);

		$ct = DB::select("SELECT data, txv1, txv2, txv2/total as ratio FROM vwRingCTTxCountByDay order by data desc limit 24;");
		array_push($ringct, $ct);		
		
		$ct = DB::select("SELECT *, v2/total as ratio FROM vwRingCTTxCountByMonth order by data limit 12;");
		array_push($ringct, $ct);
*/		
    return $this->showRingCTTransactions();
  }
	
	public static function showRingCTTransactions(){
		$ringct = [];
		
		$ct = DB::select("SELECT data, hora, txv1, txv2, txv2/total as ratio FROM vwRingCTTxCountByHour order by data desc, hora desc limit 24;");
		array_push($ringct, $ct);

		$ct = DB::select("SELECT data, txv1, txv2, txv2/total as ratio FROM vwRingCTTxCountByDay order by data desc limit 24;");
		array_push($ringct, $ct);				
		
		return view('stats.ringct_transactions', compact('ringct'));
	}
	
	public static function showRingSize(){
		
		$ring_size = [];
		
    $number_of_days = 1; //last day
    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
		array_push($ring_size, $m[0]);
    
    $number_of_days = 7; //last week
    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
    array_push($ring_size, $m[0]);
    
    $number_of_days = 30; //last month
    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
    array_push($ring_size, $m[0]);
    
    $number_of_days = 365; //last year
    $m = DB::select("Call get_mixin_stats(?);", [$number_of_days]);
    array_push($ring_size, $m[0]);		
		
		return view('stats.ring_size', compact('ring_size'));
	}
	
	public static function showBlockMedians(){

		DB::setFetchMode(PDO::FETCH_ASSOC);
		$result = DB::select("SELECT height, size FROM blocks order by height desc limit 1000;");

		$rs = array_column($result, "size");

		$arr100 = array_slice($rs,0,100);
		$arr200 = array_slice($rs,0,200);
		$arr400 = array_slice($rs,0,400);
		$arr600 = array_slice($rs,0,600);
		$arr800 = array_slice($rs,0,800);

		$medians["median100"] = StatsController::calculateMedian($arr100);
		$medians["median200"] = StatsController::calculateMedian($arr200);
		$medians["median400"] = StatsController::calculateMedian($arr400);
		$medians["median600"] = StatsController::calculateMedian($arr600);
		$medians["median800"] = StatsController::calculateMedian($arr800);
		$medians["median1000"] = StatsController::calculateMedian($rs);

		return view('stats.block_medians', compact('medians'));

	}

	public static function showBlockchainGrowth(){
		
		$growth = DB::select("SELECT * FROM vw_blockchain_size_by_month order by month;");
		
		return view('stats.blockchain_growth', compact('growth'));
		
	}
	
	public static function showTransactionsStats(){
		
		$txs = []; 
		$number_of_days = 1; //last day
		$tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
		array_push($txs, $tx[0]);
		
		$number_of_days = 7; //last day
		$tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
		array_push($txs, $tx[0]);
		
		$number_of_days = 30; //last day
		$tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
		array_push($txs, $tx[0]);
		
		$number_of_days = 365; //last day
		$tx = DB::select("Call get_tx_per_block(?);", [$number_of_days]);
		array_push($txs, $tx[0]);		
		
		return view('stats.transactions', compact('txs'));
		
	}	
  
  public static function showTransactionStats($period = "m", $records = 12){
    if ($records > 120) {
      $records = 120;
    }

    if ($records < 1 ) {
      $records = 10;
    }

    switch ($period) {
      case "m":
        $viewname = "vwTxCountByMonth";
        break;
      case "h":
        $viewname = "vwTxCountByHour";
        break;
      default:
        $viewname = "vwTxCountByDay";
    }

    $rows = DB::select("SELECT * FROM ".$viewname." LIMIT ".$records.";");
    return view('stats.tx_details', compact('rows'));
    
  }
  
	public static function calculateMedian($arr) {

		sort($arr);
		$count = count($arr);
		$middleval = floor(($count-1)/2);

		if($count % 2) {
			$median = $arr[$middleval];
		} else {
			$low = $arr[$middleval];
			$high = $arr[$middleval+1];
			$median = (($low+$high)/2);
		}
		return $median;
	}
  
}
