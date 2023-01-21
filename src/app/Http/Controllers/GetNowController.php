<?php

namespace App\Http\Controllers;

use App\Models\Now;
use App\Models\NowInterface;
use Carbon\Carbon;

class GetNowController extends Controller
{
  private $constNow;

  public function __construct(NowInterface $param = null) //引数に「NowInterfaceを実装したクラス」を設定
  {
    //コンストラクタで、外部から渡された引数を、プライベート変数constNowに設定
    $this->constNow = $param;
  }



  //【テストが書きづらいコード】内部でクラスをインスタンス化して現在日時を取得する
  public function getNowDontUseDi(): string
  {
    //このメソッド内でNowクラスをインスタンス化して、現在日時を取得
    $nowClass = new Now();
    $now = $nowClass->returnNow();

    return $now;
  }



  //【テストが書きやすいコード①】DIを使って現在日時を取得する
  public function getNowUseDi(): string
  {
    //コンストラクタで設定した(外部から渡された)Nowクラスのインスタンスを使って、現在日時を取得
    $now = $this->constNow->returnNow();

    return $now;
  }



  //【テストが書きやすいコード②】Carbon(ライブラリ)を使って現在日時を取得するメソッド
  public function getNowUseCarbon(): string
  {
    //CarbonというDatetimeをラップしたライブラリを使って、現在日時を取得
    $now = Carbon::now()->format('Y-m-d H:i:s.v');

    return $now;
  }


}