<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     */
    public function getAllCurrencies(): void
    {
        $response = $this->post('/api/get-values');

        $result = $response->decodeResponseJson()['currencies'];
        $expected = [
            "JPY",
            "GBP",
            "EUR",
        ];

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'currencies']);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     */
    public function makeExchangeOrder(): void
    {
        $response = $this->post(
            '/api/make-exchange-order',
            [
                'currency' => 'EUR',
                'amount' => 100,
            ]
        );

        $amountInUSD = $response->decodeResponseJson()['order']['amount_in_usd'];
        $response->assertStatus(200);
        $this->assertEquals(116.28800549684021, $amountInUSD);
    }

    /**
     * @param $currency
     * @param $amount
     * @param $result
     * @return void
     * @throws Throwable
     * @test
     * @dataProvider withSurchargeData
     */
    public function getCalculateWithSurcharge($currency, $amount, $result): void
    {
        $this->withoutExceptionHandling();
        $response = $this->post(
            '/api/calculate-with-surcharge',
            [
                'currency' => $currency,
                'amount' => $amount,
            ]
        );

        $calculated = $response->decodeResponseJson()['amount'];
        $response->assertStatus(200);
        $this->assertEquals($calculated, $result);
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     * @dataProvider withoutSurchargeData
     */
    public function getCalculate($currency, $amount, $result): void
    {
        $this->withoutExceptionHandling();
        $response = $this->post(
            '/api/calculate',
            [
                'currency' => $currency,
                'amount' => $amount,
            ]
        );

        $calculated = $response->decodeResponseJson()['amount'];
        $response->assertStatus(200);
        $this->assertEquals($calculated, $result);
    }

    public function withSurchargeData(): array
    {
        return [
            ['EUR', 100, 116.28800549684021],
            ['GBP', 100, 147.64236239028767],
            ['JPY', 100, 1.0030792199309508],
        ];
    }
    public function withoutSurchargeData(): array
    {
        return [
            ['EUR', 100, 113.01069533220624],
            ['GBP', 100, 140.6117737050359],
            ['JPY', 100, 0.9330969487729776],
        ];
    }

}
