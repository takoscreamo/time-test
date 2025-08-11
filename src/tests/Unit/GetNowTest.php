<?php

namespace Tests\Unit;

use App\Http\Controllers\GetNowController;
use App\Models\NowInterface;
use Carbon\Carbon;
use DateTime;
use Mockery;
use Tests\TestCase;

/**
 * DIパターンの重要性を学ぶためのテスト
 *
 * このテストでは、以下の3つのアプローチを比較します：
 * 1. DIを使わない場合（テストが書きづらい）
 * 2. DIを使う場合（テストが書きやすい）
 * 3. Carbonライブラリを使う場合（テストが書きやすい）
 */
class GetNowTest extends TestCase
{
    private string $testNow;

    protected function setUp(): void
    {
        parent::setUp();
        // テスト実行時の日時を記録（ミリ秒まで）
        $this->testNow = (new DateTime())->format('Y-m-d H:i:s.v');
    }

    protected function tearDown(): void
    {
        // Carbonのテスト時間をリセット（他のテストに影響しないように）
        Carbon::setTestNow();
        Mockery::close();
        parent::tearDown();
    }

    /**
     * 【問題の例】DIを使わない場合のテスト
     *
     * 問題点：
     * - メソッド内でnew Now()を実行
     * - テスト実行時とメソッド実行時で時間が異なる
     * - テストで時間を制御できない
     *
     * 結果：テストが不安定（flaky test）
     */
    public function test_DIを使わない場合_現在日時の取得は失敗する()
    {
        // テスト対象のコントローラーをインスタンス化
        $controller = new GetNowController();

        // メソッドを実行（内部でnew Now()が実行される）
        $methodNow = $controller->getNowWithoutDi();

        // テスト実行時とメソッド実行時で時間が異なるため、このテストは失敗する
        $this->assertNotEquals(
            $this->testNow,
            $methodNow,
            'DIを使わない場合：テスト実行時とメソッド実行時で時間が異なるため、テストが不安定になります'
        );
    }

    /**
     * 【解決策①】DIを使う場合のテスト
     *
     * 利点：
     * - 外部からモックオブジェクトを注入可能
     * - テストで戻り値を完全に制御できる
     * - テストが安定する
     *
     * 結果：テストが成功（安定）
     */
    public function test_DIを使う場合_現在日時の取得は成功する()
    {
        // テスト用のモックオブジェクトを作成
        $nowMock = Mockery::mock(NowInterface::class);
        $nowMock->shouldReceive('returnNow')
            ->once()  // 1回だけ呼ばれることを期待
            ->andReturn($this->testNow);  // テストで制御した値を返す

        // モックオブジェクトをコントローラーに注入
        $controller = new GetNowController($nowMock);

        // メソッドを実行
        $methodNow = $controller->getNowWithDi();

        // モックで制御した値と一致するため、テストが成功する
        $this->assertEquals(
            $this->testNow,
            $methodNow,
            'DIを使う場合：モックで時間を制御できるため、テストが安定します'
        );
    }

    /**
     * 【解決策②】Carbonライブラリを使う場合のテスト
     *
     * 利点：
     * - ライブラリのテスト時間固定機能を使用
     * - テスト内で時間を制御できる
     * - テストが安定する
     *
     * 結果：テストが成功（安定）
     */
    public function test_Carbonを使う場合_現在日時の取得は成功する()
    {
        // Carbonのテスト時間を現在時刻で固定化
        // このテストケース終了時まで、Carbon::now()は固定された時刻を返す
        Carbon::setTestNow(now());

        // 固定化された時刻でテスト用の日時を取得
        $testNow = Carbon::now()->format('Y-m-d H:i:s.v');

        // テスト対象のコントローラーをインスタンス化
        $controller = new GetNowController();

        // メソッドを実行（Carbon::now()が固定された時刻を返す）
        $methodNow = $controller->getNowWithCarbon();

        // 固定化された時刻と一致するため、テストが成功する
        $this->assertEquals(
            $testNow,
            $methodNow,
            'Carbonを使う場合：ライブラリのテスト時間固定機能により、テストが安定します'
        );
    }
}
