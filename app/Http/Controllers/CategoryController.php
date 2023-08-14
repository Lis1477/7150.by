<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Traits\SortAndPaginateTrait;
use App\Traits\FilterTrait;

use App\Category;
use App\Item;
use App\Characteristic;
use App\CharacteristicItem;
use App\CategoryBanner;

class CategoryController extends Controller
{
    use SortAndPaginateTrait, FilterTrait;

    public function index(Request $request, $id, $slug)
    {

        // берем данные категории
        $category = Category::where('id_1c', $id)->first();
        $data['current_cat'] = $category;

        // в массив id категорий    
        $cat_arr[] = $category->id_1c;

        // берем дочерние категории
        $subs = Category::where([['parent_id_1c', $category->id_1c], ['display', 1]])->orderBy('order')->get();
        $data['sub_cats'] = $subs;

        // если не пусто
        if ($subs->count()) {
            // берем id подкатегорий
            $sub_ids = $subs->pluck('id_1c')->toArray();

            // добавляем в массив категорий
            $cat_arr = array_merge($cat_arr, $sub_ids);

            // берем под под категории
            $sub_sub_ids = Category::whereIn('parent_id_1c', $sub_ids)
                ->where('display', 1)
                ->pluck('id_1c')->toArray();

            // если не пусто
            if (count($sub_sub_ids)) {
                // добавляем в массив категорий
                $cat_arr = array_merge($cat_arr, $sub_sub_ids);
            }
        }

        // берем товары
        $items = Item::whereIn('category_id_1c', $cat_arr)->where([['count', '>', 0], ['for_sale', 1]]);

        // берем данные фильтров, если есть
        if (isset($request->filters)) {
            $filter_data = $request->filters;
        } else {
            $filter_data = [];
        }

        // фильтруем, берем данные для фильтров
        $data = array_merge($data, $this->getFiltred($items, $filter_data));

        // если это ajax запрос количества **************************
        if ($request->ajax()) {
            // отдаем количество
            return $data['items']->count();
        }
        // **********************************************************

        // сортировка и пагинация
        $data = array_merge($data, $this->getSortedAndPaginated($data['items'], $request));

        // берем баннеры категории
        $banners = CategoryBanner::where('categories', 'like', '%'.$category->id_1c.'%')
            ->orWhere('categories', '')
            ->get();
        $data['banners'] = $banners;

        // для метатега title
        if(trim($category->title)) {
            $title = $category->title;
        } else {
            $title = $category->name;
        }
        $data['title'] = $title;

        // для метатэга keywords
        $keywords = trim($category->keywords);
        $data['keywords'] = $keywords;

        // для метатэга description
        $description = trim($category->description);
        $data['description'] = $description;

        // выводим страницу категорий с товарами
        return view('category_page')->with($data);

    }

    public function newItems(Request $request)
    {

        // берем товары
        $items = Item::where([['is_new_item', 1], ['count', '>', 0], ['for_sale', 1]]);

        // берем данные фильтров, если есть
        if (isset($request->filters)) {
            $filter_data = $request->filters;
        } else {
            $filter_data = [];
        }

        // фильтруем, берем данные для фильтров
        $data = $this->getFiltred($items, $filter_data);

        // если это ajax запрос количества **************************
        if ($request->ajax()) {
            // отдаем количество
            return $data['items']->count();
        }
        // **********************************************************

        // сортировка и пагинация
        $data = array_merge($data, $this->getSortedAndPaginated($data['items'], $request));

        // выводим страницу товаров
        return view('new_items_page')->with($data);
    }

    public function discountedItems(Request $request)
    {

        // берем товары категрии
        $items = Item::where([['category_id_1c', 3149], ['count', '>', 0], ['for_sale', 1]]);

        // берем данные фильтров, если есть
        if (isset($request->filters)) {
            $filter_data = $request->filters;
        } else {
            $filter_data = [];
        }

        // фильтруем, берем данные для фильтров
        $data = $this->getFiltred($items, $filter_data);

        // если это ajax запрос количества **************************
        if ($request->ajax()) {
            // отдаем количество
            return $data['items']->count();
        }
        // **********************************************************

        // сортировка и пагинация
        $data = array_merge($data, $this->getSortedAndPaginated($data['items'], $request));

        // выводим страницу товаров
        return view('discounted_items_page')->with($data);
    }


}
