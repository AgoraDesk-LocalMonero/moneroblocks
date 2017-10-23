<?php

namespace App\Http\Controllers;

use App\Libraries\MoneroDaemonRPC;
use App\Libraries\StringHelpers;
use DB;

class APIController extends Controller
{

	public function getStats() {

		$stats = DB::select('SELECT height, coins_generated, block_difficulty, timestamp, tx.amount as reward FROM blocks join transactions tx ON height = tx.bl_height AND coinbase_tx = 1 ORDER BY bl_height DESC LIMIT 1;');
		
		$data['difficulty'] = $stats[0]->block_difficulty;
    $data['height'] = $stats[0]->height;
    $data['hashrate'] = $stats[0]->block_difficulty / 60 / 2; //TODO: dinamically get the target block time (by height or by version?)
    $data['total_emission'] = $stats[0]->coins_generated;
		$data['last_reward'] = $stats[0]->reward;
		$data['last_timestamp'] = $stats[0]->timestamp;

		echo json_encode($data);
	}
	
	public function getBlockHeader($param) {
		$rpc = new MoneroDaemonRPC();

		//o tamanho da hash � 64 bytes
		if (StringHelpers::isValidHash($param)){
			$block = json_decode($rpc->getBlockHeaderByHash($param), true);
		}elseif (StringHelpers::isValidHeight($param)){
			$block = json_decode($rpc->getBlockHeaderByHeight($param), true);
		}else{
			$data['status'] = "ERROR";
			$data['error'] = 'Invalid parameter';
			$data['method'] = 'get_block_header';
			$data['param_value'] = $param;
		}

		if (array_key_exists("result",$block)){
			$data = $block['result'];
		}else{
			$data['status'] = "ERROR";
			$data['error'] = 'Block not found';
			$data['method'] = 'get_block_header';
			$data['param_value'] = $param;
		}

		echo json_encode($data);
	}	

	public function getBlockData($param) {
		$rpc = new MoneroDaemonRPC();

		//o tamanho da hash � 64 bytes
		if (StringHelpers::isValidHash($param)){
			$block = json_decode($rpc->getBlockHeaderByHash($param), true);
		}elseif (StringHelpers::isValidHeight($param)){
			$block = json_decode($rpc->getBlockHeaderByHeight($param), true);
		}else{
			$data['status'] = "ERROR";
			$data['error'] = 'Invalid parameter';
			$data['method'] = 'get_block_data';
			$data['param_value'] = $param;
		}

		if (array_key_exists("result",$block)){
			$blockheader = $block['result']['block_header'];
			$data['status'] = 'OK';
			$block_data = json_decode($rpc->getBlockInfoByHash($blockheader['hash']), true);

			//remove unnecessary data
			if (array_key_exists("result",$block_data)){
				unset($block_data['result']['json']);
				unset($block_data['result']['blob']);
			}
				
			$data['block_data'] = $block_data; 

		}else{
			$data['status'] = "ERROR";
			$data['error'] = 'Block not found';
			$data['method'] = 'get_block_data';
			$data['param_value'] = $param;
		}

		echo json_encode($data);
	}	
	
	public function getTransactionData($param) {
		$rpc = new MoneroDaemonRPC();

		if (StringHelpers::isValidHash($param)){
			$rpc_resp = json_decode($rpc->getTransactionJson($param), true);

			//if the tx hash exists it returns an object containing "txs_as_hex"
			//if not returns an object containing "missed_tx"
			if(array_key_exists("txs_as_hex",$rpc_resp)) {
				$tx_list = $rpc_resp['txs'];

				//we are only expecting 1 transaction
				$tx_details = json_decode($tx_list[0]['as_json'],true);

				$data['status'] = "OK";
				$data['transaction_data'] = $tx_details;
			} else{
				$data['status'] = "ERROR";
				$data['error'] = 'Transaction not found';
				$data['method'] = 'get_transaction_data';
				$data['param_value'] = $param;
			}
			
		}else{
			$data['status'] = "ERROR";
			$data['error'] = 'Invalid parameter';
			$data['method'] = 'get_transaction_data';
			$data['param_value'] = $param;
		}		
			
		echo json_encode($data);	
	}	
	
	public function isKeyImageSpent($param) {
		$rpc = new MoneroDaemonRPC();

		if (StringHelpers::isValidHash($param)){
			$rpc_resp = json_decode($rpc->isKeyImageSpent($param), true);

			$data = $rpc_resp;
		}else{
			$data['status'] = "ERROR";
			$data['error'] = 'Invalid parameter';
			$data['method'] = 'is_key_image_spent';
			$data['param_value'] = $param;			
		}
		
			echo json_encode($data);
	}	
	
}
