<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use \Config;

class ComposerServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    view()->composer(
      'explorer.network_stats', function ($view) {
      $coin = Config::get('app.denomination');
      
      $result = DB::select('SELECT height, coins_generated, block_difficulty, timestamp, tx.amount as reward FROM blocks join transactions tx ON height = tx.bl_height AND coinbase_tx = 1 ORDER BY bl_height DESC LIMIT 1;');

      $net_stats['diff'] = $result[0]->block_difficulty;
      $net_stats['hashrate'] = round($result[0]->block_difficulty/120,2);
      $net_stats['emission'] = round($result[0]->coins_generated/$coin,0);
      $net_stats['height'] = $result[0]->height+1; //The target height is the next block
      
      $view->with('net_stats', $net_stats);
    });
  }

  /**
  * Register any application services.
  *
  * @return void
  */
  public function register()
  {
    //
  }
}
