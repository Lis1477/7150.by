<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Collection;

use App\Category;
use App\Item;

class BreadCrumbsComposer
{

    public function compose(View $view)
    {

        // берем url
        $url = request()->path();

        // делим
        $url_arr = explode('/', $url);

        // тип 
        $bread_crumbs_type = $url_arr[0];

        // id_1c категории
        if ($bread_crumbs_type != 'tovar') {
            $category_id_1c = $url_arr[1];
        } else {
            $category_id_1c = Item::where('id_1c', $url_arr[1])->first(['category_id_1c'])->category_id_1c;
        }

        // id_1c родителя
        $parent_id_1c = Category::where('id_1c', $category_id_1c)->first(['parent_id_1c'])->parent_id_1c;

        // определяем уровень вложенности категории
        if($parent_id_1c > 0) {
            $parent = Category::where('id_1c', $parent_id_1c)->first(['parent_id_1c'])->parent_id_1c;
            if($parent > 0) {
                $cat_level = 3;
            } else {
                $cat_level = 2;
            }
        } else {
            $cat_level = 1;
        }

        // собираем данные для Хлебных крошек ********************************
        $collect = new Collection;
        if($cat_level == 1) {
            // добавляем только 1-й уровень
            $collect->push([
                'id_1c' => $category_id_1c,
                'all_cats' => Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(),
            ]);
        } elseif($cat_level == 2) {
            // добавляем 1-й уровень
            $collect->push([
                'id_1c' => $parent_id_1c,
                'all_cats' => Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(),
            ]);
            // добавляем 2-й уровень
            $collect->push([
                'id_1c' => $category_id_1c,
                'all_cats' => Category::where([['parent_id_1c', $parent_id_1c], ['display', 1]])->orderBy('order')->get(),
            ]);
        } else { // если у категории 3-й уровень
            // добавляем 1-й уровень
            $collect->push([
                'id_1c' => $parent,
                'all_cats' => Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(),
            ]);

            // добавляем 2-й уровень
            $collect->push([
                'id_1c' => $parent_id_1c,
                'all_cats' => Category::where([['parent_id_1c', $parent], ['display', 1]])->orderBy('order')->get(),
            ]);

            // добавляем 3-й уровень
            $collect->push([
                'id_1c' => $category_id_1c,
                'all_cats' => Category::where([['parent_id_1c', $parent_id_1c], ['display', 1]])->orderBy('order')->get(),
            ]);
        }
        $data['bread_crumbs'] = $collect;
        $data['bread_crumbs_type'] = $bread_crumbs_type;
        $data['parent_id_1c'] = $parent_id_1c;

        return $view->with($data);
    }

}