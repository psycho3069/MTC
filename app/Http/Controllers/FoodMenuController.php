<?php

namespace App\Http\Controllers;

use App\FoodMenu;
use App\MealItem;
use App\MenuType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = FoodMenu::all()->sortByDesc('id');
//        return $menus->find(1)->menuItems->first()->mealItem;
        return view('admin.mis.hotel.restaurant.food.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu_types'] = MenuType::all();
        $data['menu_items'] = MealItem::all();

        return view('admin.mis.hotel.restaurant.food.menu.create', compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Please Enter A Name',
        ]);
        $input = $request->input;
        $menu = FoodMenu::create( $request->except('_token', 'input'));

        foreach ( $input as $item) {
            $menu->items()->create( $item);
        }

        return redirect('food/menu')->with('success', '<b>'.$menu->name.'</b> has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
