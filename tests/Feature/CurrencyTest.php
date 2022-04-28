<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->assertEquals(91.0533288, $amountInUSD);
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
            ['EUR', 100, 91.0533288],
            ['GBP', 100, 74.67369],
            ['JPY', 100, 11520.8944325],
        ];
    }
    public function withoutSurchargeData(): array
    {
        return [
            ['EUR', 100, 88.4872],
            ['GBP', 100, 71.1178],
            ['JPY', 100, 10717.1111],
        ];
    }

}
