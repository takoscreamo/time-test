<?php

namespace Tests\Feature;

use App\Http\Controllers\GetNowController;
use App\Models\NowInterface;
use Carbon\Carbon;
use DateTime;
use Tests\TestCase;

class GetNowTest extends TestCase
{
    public function test_NGケース_現在日時のテスト_DI使わない()
    {
        //テスト実行時の日時(ミリ秒まで)を取得
        $test_now = (new DateTime())->format('Y-m-d H:i:s.v');

        //テスト対象のクラスを実体化
        $getNowClass = new GetNowController();

        //テスト対象のメソッドを呼んで、戻り値でメソッド実行時の日時を取得
        $method_now = $getNowClass->getNowDontUseDi();

        //テスト実行時の日時と、メソッド実行時の日時が同一であればOKが出る(このケースは失敗する)
        $this->assertSame($test_now, $method_now);
    }



    public function test_OKケース_現在日時のテスト_DI使う()
    {
        //テスト実行時の日時(ミリ秒まで)を取得
        $test_now = (new DateTime())->format('Y-m-d H:i:s.v');

        //テスト用のモックオブジェクトをIFで生成して、メソッドと戻り値を設定
        $nowMock = \Mockery::mock(NowInterface::class);

        $nowMock->shouldReceive('returnNow')
            ->once()
            ->andReturn($test_now);

        //テスト対象のクラスを実体化
        $getNowClass = new GetNowController($nowMock);

        //テスト対象のメソッドを呼んで、戻り値でメソッド実行時の日時を取得
        $method_now = $getNowClass->getNowUseDi();

        //テスト実行時の日時と、メソッド実行時の日時が同一であればOKが出る
        $this->assertSame($test_now, $method_now);
    }


    
    public function test_OKケース_現在日時のテスト_Carbon使う()
    {
        //このテストケース終了時まで、Carbonで取得できる日時を現時点の日時で固定化し、
        //テスト対象のメソッドと、このテスト内で、ミリ秒単位まで同じ日時を取得できるようにする
        Carbon::setTestNow(now());

        //テスト実行時の日時(ミリ秒まで)をCarbonを使って取得
        $test_now = Carbon::now()->format('Y-m-d H:i:s.v');

        //テスト対象のクラスを実体化
        $getNowClass = new GetNowController();

        //テスト対象のメソッドを呼んで、戻り値でメソッド実行時の日時を取得
        $method_now = $getNowClass->getNowUseCarbon();

        //テスト実行時の日時と、メソッド実行時の日時が同一であればOKが出る
        $this->assertSame($test_now, $method_now);
    }
}