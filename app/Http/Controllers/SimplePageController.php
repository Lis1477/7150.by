<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SimplePage;
use App\Page;

class SimplePageController extends Controller
{

    public function index($slug)
    {
        $page = SimplePage::where('slug', $slug)->first();
        $data['page'] = $page;

        if(empty($page->title)) {
            $title = $page->name." | Интернет-магазин 7150.by";
        } else {
            $title = $page->title;
        }
        $data['title'] = $title;

        $data['keywords'] = $page->keywords;
        $data['description'] = $page->description;

        return view('simple_page')->with($data);
    }

    public function services()
    {
        $services = Page::find(23);
        $data['page'] = $services;

        $data['title'] = "Сервис";
        $data['description'] = "Мы осуществляем гарантийную поддержку строительной и садовой техники, электроинструмента и бытовых приборов. В течение гарантийного срока владелец имеет право на бесплатный ремонт изделия по неисправностям, являющимися следствием производственных дефектов.";

        return view('service_page')->with($data);
    }

}
