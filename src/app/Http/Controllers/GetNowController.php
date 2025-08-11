<?php

namespace App\Http\Controllers;

use App\Models\Now;
use App\Models\NowInterface;
use Carbon\Carbon;

class GetNowController extends Controller
{
    private ?NowInterface $nowService;

    /**
     * コンストラクタ
     *
     * @param NowInterface|null $nowService 日時取得サービス
     */
    public function __construct(?NowInterface $nowService = null)
    {
        $this->nowService = $nowService;
    }

    /**
     * テストが書きづらいコード - 内部でクラスをインスタンス化して現在日時を取得
     *
     * @return string 現在日時（Y-m-d H:i:s.v形式）
     */
    public function getNowWithoutDi(): string
    {
        $nowClass = new Now();
        return $nowClass->returnNow();
    }

    /**
     * テストが書きやすいコード - DIを使って現在日時を取得
     *
     * @return string 現在日時（Y-m-d H:i:s.v形式）
     */
    public function getNowWithDi(): string
    {
        return $this->nowService->returnNow();
    }

    /**
     * テストが書きやすいコード - Carbonライブラリを使って現在日時を取得
     *
     * @return string 現在日時（Y-m-d H:i:s.v形式）
     */
    public function getNowWithCarbon(): string
    {
        return Carbon::now()->format('Y-m-d H:i:s.v');
    }
}
