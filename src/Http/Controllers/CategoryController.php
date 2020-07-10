<?php

namespace Apvanlaan\UsaEpay\Http\Controllers;

use Apvanlaan\UsaEpay\EpayCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public EpayCategory $category;

    public function __construct(Request $request)
    {
        $arr = $request->all();
        $this->category = new EpayCategory($arr);
    }

    public function create(Request $request)
    {
        $res = $this->category->createCategory();

        return json_encode($res);
    }

    /**
     * [listCategorys description].
     * @return [type] [description]
     */
    public function list()
    {
        $res = $this->category->listCategorys();

        return json_encode($res);
    }

    /**
     * [get description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function get($categorykey)
    {
        $this->category_key = $categorykey;
        $res = $this->category->getCategory();

        return $res;
    }

    /**
     * [update description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        $res = $this->category->updateCategory();

        return json_encode($res);
    }

    /**
     * [delete description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function delete(Request $request)
    {
        $res = $this->category->deleteCategory();

        return json_encode($res);
    }
}
