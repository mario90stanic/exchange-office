@component('mail::message')
# Details:
<table>
    <tr>
        <td>Foreign currency purchased</td>
        <td>{{$order->foreign_currency_purchased}}</td>
    </tr>
    <tr>
        <td>Foreign currency exchange rate</td>
        <td>{{$order->foreign_currency_exchange_rate}}</td>
    </tr>
    <tr>
        <td>Surcharge percentage</td>
        <td>{{$order->surcharge_percentage}}%</td>
    </tr>
    <tr>
        <td>Surcharge amount</td>
        <td>${{$order->surcharge_amount}}</td>
    </tr>
    <tr>
        <td>Foreign currency amount</td>
        <td>{{$order->foreign_currency_amount}} {{$order->foreign_currency_purchased}}</td>
    </tr>
    <tr>
        <td>Amount in usd</td>
        <td>${{$order->amount_in_usd}}</td>
    </tr>
    <tr>
        <td>Discount percentage</td>
        <td>{{$order->discount_percentage}}%</td>
    </tr>
    <tr>
        <td>Discount amount</td>
        <td>${{$order->discount_amount}}</td>
    </tr>
    <tr>
        <td>Created at</td>
        <td>{{$order->created_at}}</td>
    </tr>
</table>
@endcomponent
