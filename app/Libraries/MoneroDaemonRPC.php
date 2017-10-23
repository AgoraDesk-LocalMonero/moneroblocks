<?php

namespace App\Libraries;

class MoneroDaemonRPC {

	private $__url = "";
	
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
		$host = env('DAEMON_HOST', '127.0.0.1');
		$port = env('DAEMON_PORT', '18081');
		$this->__url = 'http://'.$host.':'.$port;
  }
	
		public function getInfo(){

		$data = array('id' => '0', 'jsonrpc' => '0');
		$data_string = json_encode($data);
		$path = '/getinfo';

		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function getBlockHeaderByHash($hash){
		
		$params = array("hash" => $hash);
		$data = array('id' => '0', 'jsonrpc' => '0', 'method' => 'getblockheaderbyhash', 'params' => $params);
		$data_string = json_encode($data);

		$path = '/json_rpc';
		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function getBlockHeaderByHeight($height){
		//getblockheaderbyheight:
		$params = array("height" => (int)$height );
		$data = array('id' => '0', 'jsonrpc' => '0', 'method' => 'getblockheaderbyheight', 'params' => $params);
		$data_string = json_encode($data);

		$path = '/json_rpc';
		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function getHeight($data_string, $path){

		$data = array('id' => '0', 'jsonrpc' => '0');
		$data_string = json_encode($data);
		$path = '/getheight';

		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function isKeyImageSpent($key_images){

		$data = array('key_images' => [$key_images]);
		$data_string = json_encode($data);
		$path = '/is_key_image_spent';

		$result = $this->rpc_call($data_string, $path);

			return $result;
	}

	public function getTransactionList($tx_list){

		$data = array('txs_hashes' => $tx_list);
		$data_string = json_encode($data);

		$path = '/gettransactions';
		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function getTransactionJson($param) {
		$data = array(
								'txs_hashes' => [$param],
								'decode_as_json' => true
						);
		$data_string = json_encode($data);
		
		$path = '/gettransactions';
		$result = $this->rpc_call($data_string, $path);

		return $result;		
	}
	
	public function getTransactionHex($param){
		$data = array('txs_hashes' => [$param]);
		$data_string = json_encode($data);

		$path = '/gettransactions';
		$result = $this->rpc_call($data_string, $path);

		return $result;
	}
	
	public function getTransactionPool($param = '') {
		$data = array('txs_hashes' => [$param]);
		$data_string = json_encode($data);
		
		$path = '/get_transaction_pool';
		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function getLastBlockHeader(){
		$data = array('id' => '0', 'jsonrpc' => '0', 'method' => 'getlastblockheader', 'params' => json_decode("{}"));     
		$data_string = json_encode($data);

		$path = '/json_rpc';
		$result = $this->rpc_call($data_string, $path);

		return $result;
	}

	public function getBlockInfoByHash($hash){

		$data = array('id' => '0', 'jsonrpc' => '0', 'method' => 'getblock', 'params' => $hash);
		$data_string = json_encode($data);

		$path = '/json_rpc';
		$result = $this->rpc_call($data_string, $path);		
		
		return $result;
	}

	function rpc_call($data_string, $path){
		$url = $this->__url.$path;
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);

		$result = curl_exec($ch);

		return $result;
	}
	
}
