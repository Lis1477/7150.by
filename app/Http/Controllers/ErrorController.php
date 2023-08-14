<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

use App\User;

class ErrorController extends Controller
{
    public function page404(Request $request)
    {
        return response()->view('errors.404', [], 404);
    }

    public function mail500(Request $request)
    {

        $data['page'] = $request->page;

        // отправляем письмо администратору
        Mail::send('mail.error_page_to_admin', $data, function($message) use ($data) {
            $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
            $message->to(config('email')['info_email'])->subject('ОШИБКА на сайте 7150.by');
        });

        $note = "Спасибо!\n\nПисьмо об ошибке отправлено.";

        return redirect('/')->with('note', $note);
    }

    public function emailExist(Request $request)
    {
        $email = $request->email;

        $user = User::where('email', $email)->first(['email']);

        if ($user) {
            return 1;
        } else {
            return 0;
        }
    }

    public function badToken(Request $request)
    {
        // берем урл страницы, откуда пришел
        $referer = $request->headers->get('referer');

        // если пусто, на главную
        if (!$referer) {
            $referer = "/";
        }

        // сообщение для всплывашки
        $note = "Упс! Слишком долго открыта страница.\n Мы перезагрузили страницу.\n\nПопробуйте еще раз";

        return redirect($referer)->with('note', $note);
    }

    public function ajaxBadToken()
    {
        return "bad_token";
    }

}
