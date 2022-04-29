<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\FetchingCurrenciesFailed;
use App\Factories\CurrencyFactory;
use App\Http\Requests\OrderRequest;
use App\Models\Currency;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExchangeController extends Controller
{
    /**
     * @throws Exception
     */
    public function getValues(): Response|Application|ResponseFactory
    {
        try {
            $currency = Currency::getValueNames();
        } catch (FetchingCurrenciesFailed $e) {
            return response([
                'status' => 'no_currencies_in_database',
                'message' => 'There are no currencies in the system.',
            ], 500);
        } catch (\Exception $e) {
            return response([
                'status' => 'returning_currencies_failed',
                'message' => 'Fetching currencies failed.',
            ], 500);
        }

        return response([
            'status' => 'returning_currencies',
            'message' => 'Fetching currencies successfully.',
            'currencies' => $currency,
        ], 200);
    }

    public function makeExchangeOrder(OrderRequest $order): Response|Application|ResponseFactory
    {
        try {
            $order = $order->validated();
            $currency = CurrencyFactory::make($order['amount'], $order['currency']);
            $currency->setUp();
            $order = $currency->makeOrder();
        } catch (\Exception $e) {
            return response([
                'status' => 'order_creat_failed',
                'message' => 'Creating of the order failed.',
            ], 500);
        }

        return response([
            'status' => 'order_successfully_created',
            'message' => 'Order is created successfully.',
            'order' => $order,
        ], 200);
    }

    public function getCalculateWithSurcharge(OrderRequest $order): Response|Application|ResponseFactory
    {
        try {
            $order = $order->validated();
            $currency = CurrencyFactory::make($order['amount'], $order['currency']);
            $currency->setUp();
            $calculated = $currency->getCalculatedWithSurcharge();
        } catch (\Exception $e){
            return response([
                'status' => 'calculating_amount_with_surcharge_failed',
                'message' => 'Calculating of the amount with surcharge failed.',
            ], 500);
        }

        return response([
            'status' => 'calculated_amount_with_surcharge',
            'message' => 'Calculated amount without surcharge.',
            'amount' => $calculated,
        ], 200);
    }

    public function getCalculate(OrderRequest $order): Response|Application|ResponseFactory
    {
        try {
            $order = $order->validated();
            $currency = CurrencyFactory::make($order['amount'], $order['currency']);
            $currency->setUp();
            $calculated =  $currency->getCalculatedAmount();
        } catch (\Exception $e) {
            return response([
                'status' => 'calculating_amount_failed',
                'message' => 'Calculating of the amount failed.',
            ], 500);
        }

        return response([
            'status' => 'calculated_amount',
            'message' => 'Calculated amount without surcharge.',
            'amount' => $calculated,
        ], 200);
    }
}
