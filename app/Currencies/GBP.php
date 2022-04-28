<?php declare(strict_types=1);

namespace App\Currencies;

use App\Interfaces\CurrencyInterface;
use App\Mail\OrderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class GBP extends Currency implements CurrencyInterface
{
    private object $order;

    public function action(): void
    {
        Mail::to('mario90stanic@gmail.com')->send(new OrderMail($this->order));
    }

    public function makeOrder()
    {
        $this->order = Order::make($this);
        $this->action();

        return $this->order;
    }
}
