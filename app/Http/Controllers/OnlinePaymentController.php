<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Mail;


use App\Order;

class OnlinePaymentController extends Controller
{
    public function cardOnline()
    {

        if (session("order_id")) {
            $order_id = session("order_id");
        }

        $data["order_id"] = $order_id;

        // берем ордер
        $order = Order::find($order_id);
        $data["order"] = $order;


        return view("online_payment_invoice")->with($data);
    }

    public function oplatiOnline(Request $request)
    {

        if (session("order_id")) {
            $order_id = session("order_id");
        } elseif (isset($request->order_id)) {
            $order_id = intval($request->order_id);
        } else {
            return redirect('/');
        }

        $data["order_id"] = $order_id;

        // берем ордер
        $order = Order::find($order_id);
        $data["order"] = $order;

        // формируем тело запроса
        $body = '{
    "sum": '.($order->price_total + $order->price_delivery).',
    "orderNumber": "'.$order->id.'",
    "regNum": "OPL000053722",
    "details": {
        "items": [';

        $body_items = '';
        foreach ($order->items as $item) {

            $body_items .= '
            {
                "type": 1,
                "name": "'.addslashes($item->name).'",
                "quantity": '.$item->count.',
                "price": '.$item->price.',
                "cost": '.$item->price * $item->count.'
            },';
        }

        // если есть доставка
        if ($order->price_delivery != 0) {

            $body_items .= '
            {
                "type": 2,
                "name": "Доставка",
                "quantity": 1,
                "price": '.$order->price_delivery.',
                "cost": '.$order->price_delivery.'
            },';
        }

        // удаляем запятую в конце
        $body_items = substr($body_items, 0, -1);

        $body .= $body_items;

        $body .= '
        ],
        "amountTotal": '.($order->price_total + $order->price_delivery).',
        "footerInfo": "7150.by - Все лучшее для Вас!"
    }
}';
// dd($body);

        $client = new Client();

        try {

            $response = $client->post("https://cashboxapi.o-plati.by/ms-pay/pos/webPayments", [
                "connect_timeout" => 10,
                "headers" => [
                    "regNum" => "OPL000053722",
                    "password" => "AlFAsaD1234",
                    "Content-Type" => "application/json",
                ],
                "body" => $body,
            ]);

            // получаем тело ответа
            $response_body = json_decode((string)$response->getBody());
            // получаем строку для формирования qr-кода
            $qr_string = $response_body->dynamicQR;

            // получаем id платежа
            $qr_id = $response_body->paymentId;

        } catch (GuzzleException $e) {

        }

        $data['qr_string'] = $qr_string;
        $data['qr_id'] = $qr_id;

        return view("oplati_payment_page")->with($data);
    }

    public function successOnline(Request $request)
    {
        // берем id заказа
        $order_id = intval($request->wsb_order_num);
        $data['order_id'] = $order_id;

        return view('online_payment_success')->with($data);
    }

    public function cancelOnline(Request $request)
    {
        // берем id заказа
        $order_id = intval($request->wsb_order_num);
        $data['order_id'] = $order_id;

        return view('online_payment_cancel')->with($data);
    }

    // проверка статуса оплаты для ОПЛАТИ
    public function ajaxGetStatus(Request $request)
    {
        // берем id платежа
        $payment_id = intval($request->payment_id);

        // берем номер ордера
        $order_id = intval($request->order_id);

        $client = new Client();

        try {

            $response = $client->get("https://cashboxapi.o-plati.by/ms-pay/pos/payments/".$payment_id, [
                "connect_timeout" => 1,
                "headers" => [
                    "regNum" => "OPL000053722",
                    "password" => "AlFAsaD1234",
                ],
            ]);

            // получаем тело ответа
            $response_body = json_decode((string)$response->getBody());
            // получаем строку для формирования qr-кода
            $payment_status = $response_body->status;

        } catch (GuzzleException $e) {

        }

        // если заказ оплачен
        if($payment_status == 1) {

            $data['order_id'] = $order_id;

            Mail::send('mail.oplati_payment', $data, function($message) use ($data) {
                $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
                $message->to(config('email')['order_email'])->subject('Оплата заказа №'.$data['order_id']);
            });

        }

        return $payment_status;
    }

    public function eripOnline()
    {

        if (session("order_id")) {
            $order_id = session("order_id");
        }

        $data["order_id"] = $order_id;

        // берем ордер
        $order = Order::find($order_id);
        $data["order"] = $order;


        return view("erip_payment_invoice")->with($data);
    }
}
