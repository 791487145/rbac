<?php

namespace App\Modules\Manage\Http\Controllers\Dash;

use App\Http\Controllers\ManageController;
use App\Modules\Manage\Model\MenuModel;
use Illuminate\Support\Facades\Session;

class IndexController extends ManageController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $menus = MenuModel::getMenuPermission();
        //$menus = $this->menus;
        dd($this->menu_data);
        return view("Manage.dash.index",compact('menus'));
    }
}
