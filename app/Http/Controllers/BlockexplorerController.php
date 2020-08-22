<?php

namespace App\Http\Controllers;

use App\Libraries\StringHelpers;
use App\Libraries\MoneroDaemonRPC;
use DB;

class BlockexplorerController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

	public function listBlocks($height = 0) 
  {
		$rpc = new MoneroDaemonRPC();
    $block_limit = 50;

		if ($height > 0) {
			$block_list = DB::select('select height, size, hash, timestamp, tx_count from blocks where height <= ? order by height desc limit ?', [$height, $block_limit]);	
		}else{
			$block_list = DB::select('select height, size, hash, timestamp, tx_count from blocks order by height desc limit ?', [$block_limit]);	
		}

		$page_height = $block_list[0]->height;
		$higher = ($height==0 ? -1 : $page_height+$block_limit);	//$hight=0 means we are on the main page, no need to see higher blocks
		$lower = $page_height-$block_limit;

//		$transaction_pool = json_decode($rpc->getTransactionPool(), false);

		if(isset($transaction_pool->transactions)){
			$transaction_pool = $transaction_pool->transactions;
		}else{
			$transaction_pool = [];
		}

	return view('explorer.home', compact("block_list", "higher", "lower", "transaction_pool"));
  }

  public function showBlock($query)
  {
		if (StringHelpers::isValidHeight($query)) {
			$block_height = $query;
			
			$block = DB::select('select * from blocks where height = ?', [$block_height]);

			if(count($block) == 0){
				$message = "The Monero chain has not reached height ".$block_height." yet. Be patient, miners are doing their best!"; 
				return view('static.not_found', compact('message'));
			}			
			
		}elseif(StringHelpers::isValidHash($query)){
			$block = DB::select('select * from blocks where hash = ?', [$query]);
			
			if(count($block) == 0){
				$message = "Hmmm. That's strange. I don't think i have seen that block hash around here. Are you sure you meant ".$query."?"; 
				return view('static.not_found', compact('message'));
			}
			
			$block_height = $block[0]->height;
			//var_dump($block);
		}	
		        
    //ordering by coinbase desc, ensures the coinbase tx comes first.
    $transactions = DB::select('select * from transactions where bl_height = ? order by coinbase_tx desc, txid', [$block_height]);
    
    $coinbase = array_slice($transactions,0,1);
		
		//if the result has other tx besides Coinbase remove them
		$transactions = array_diff_key($transactions, $coinbase);
						
	  $previous_block = max(0,$block_height-1);
	  $next_block     = $block_height+1;
    
    return view('explorer.block_details', compact("block", "transactions", "coinbase", "previous_block", "next_block"));
  }
  
  public function showTransaction($tx_hash)
  {
    //TODO:
    //check if tx hash is valid
    
    $transaction = DB::select('select * from transactions where hash = ?', [$tx_hash]);
    
    $bl_height = $transaction[0]->bl_height;
    $tx_id = $transaction[0]->txid;
    
    $outputs = DB::select('select bl_height, txid, voutid, coalesce(true_amount,amount) as amount, public_key from vout where bl_height = ? and txid = ?', [$bl_height, $tx_id]);
    
    $inputs = DB::select('select * from vin where bl_height = ? and txid = ?', [$bl_height, $tx_id]);

		foreach($inputs as &$input){
			$offsets = (object)[]; 
			$offsets = DB::select("Call get_offset_link(?, ?, ?);", [$bl_height, $tx_id, $input->vinid]);
			$input->offsets = $offsets;
		}				
    
    return view('explorer.transaction_details', compact('transaction', 'outputs', 'inputs', 'offsets'));
  }
	
	public function showTransactionsByPaymentId($payment_id){

		$transactions = DB::select("SELECT * FROM vw_payment_id WHERE payment_id = '".$payment_id."';");

		return view('explorer.list_transactions', compact('transactions','payment_id'));
	}	
	
	public function search($query){
		$result = false;
		$found = false;
		$view = view('static.not_found', compact('query'));

		//is it a Monero Address? Really?
		if (StringHelpers::isValidAddress($query)) {
			$view = view('static.address_not_found', compact('query'));
			
		} elseif (StringHelpers::isValidHeight($query)) {
			$view = $this->showBlock($query);
			
		}elseif(StringHelpers::isValidHash($query)){
			$result = DB::select("SELECT count(hash) row_count FROM transactions WHERE hash = '".$query."';");

			if($result[0]->row_count > 0){
				$view = $this->showTransaction($query);
			}

			$result = DB::select("SELECT count(hash) row_count FROM vw_payment_id WHERE payment_id = '".$query."';");

			if($result[0]->row_count > 0){
				$view = $this->showTransactionsByPaymentId($query);
			}

			$result = DB::select("SELECT height FROM blocks WHERE hash = '".$query."';");

			if(count($result) > 0){
				$view = $this->showBlock($result[0]->height);
			}
		}

		return $view;
	}	
}
