<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use DB;
use PDF;
use Auth;
use Session;
use Exception;


class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return voidna
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


//------- METHODS FOR SUPPLIER --------//
    //SUPPLIER
    public function supplier(){
        $supplier_info=DB::table('r1_restaurant_suppliers')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_suppliers=view('admin.restaurant.supplier.suppliers')
                         ->with('supplier_info',$supplier_info);
        return view('admin.master')
                         ->with('admin.restaurant.supplier.suppliers',$manage_suppliers);
    }
    //ADD-SUPPLIER
    public function add_supplier(){
        return view('admin.restaurant.supplier.add_supplier');
    }
    //SAVE SUPPLIER TO DATABASE
    public function save_supplier(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:r1_restaurant_suppliers'],
          'address'  => ['required', 'string', 'max:100'],
          'phone_no'  => ['required', 'max:20']

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone_no'] = $request->phone_no;
        $data['created_at'] = now();

        DB::table('r1_restaurant_suppliers')->insert($data);
        Session::put('message','Supplier is Added Successfully');
        return Redirect::to('/restaurant/supplier/add_supplier');
    }
    //EDIT SUPPLIER
    public function edit_supplier($id)
    {
        $supplier=DB::table('r1_restaurant_suppliers')
                           ->where('id',$id)
                           ->first();
        $manage_supplier=view('admin.restaurant.supplier.edit_supplier')
                         ->with('supplier',$supplier);
        return view('admin.master')
                         ->with('admin.restaurant.supplier.edit_supplier',$manage_supplier);
    }
    //UPDATE SUPPLIER
    public function update_supplier(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'address'  => ['required', 'string', 'max:100'],
          'phone_no'  => ['required', 'max:20']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone_no'] = $request->phone_no;

        DB::table('r1_restaurant_suppliers')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Supplier has been updated Successfully');
        return Redirect::to('/restaurant/supplier/suppliers');
    }
    //DELETE SUPPLIER FROM DATABASE
    public function delete_supplier($id)
    {
        DB::table('r1_restaurant_suppliers')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Supplier has been deleted Successfully');
        return Redirect::to('/restaurant/supplier/suppliers');
    }



//------- METHODS FOR RECEIVER --------//
    //RECEIVER
    public function receiver(){
        $receiver_info=DB::table('r2_restaurant_receivers')
                           ->orderBy('id', 'desc')
                           ->get();
        $employee_info=DB::table('e4_employees')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_receivers=view('admin.restaurant.receiver.receivers')
                         ->with('receiver_info',$receiver_info)
                         ->with('employee_info',$employee_info);
        return view('admin.master')
                         ->with('admin.restaurant.receiver.receivers',$manage_receivers);
    }
    //ADD-RECEIVER
    public function add_receiver(){
        $employee_info=DB::table('e4_employees')
                           ->orderBy('id', 'desc')
                           ->get();
        return view('admin.restaurant.receiver.add_receiver')
                          ->with('employee_info',$employee_info);
    }
    //SAVE RECEIVER TO DATABASE
    public function save_receiver(Request $request)
    {
        $this->validate($request, [
          'employee_id'  => ['required', 'integer', 'unique:r2_restaurant_receivers']
        ]);
        $data = array();
        $data['employee_id'] = $request->employee_id;
        $data['created_at'] = now();

        DB::table('r2_restaurant_receivers')->insert($data);
        Session::put('message','Receiver is Added Successfully');
        return Redirect::to('/restaurant/receiver/add_receiver');
    }
    //DELETE RECEIVER FROM DATABASE
    public function delete_receiver($id)
    {
        DB::table('r2_restaurant_receivers')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Receiver has been deleted Successfully');
        return Redirect::to('/restaurant/receiver/add_receiver');
    }



//------- METHODS FOR GROCERY-CATEGORY --------//
    //GROCERY-CATEGORY
    public function grocery_category(){
        $grocery_category_info=DB::table('r3_grocery_categories')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_grocery_categories=view('admin.restaurant.grocery_category.grocery_categories')
                         ->with('grocery_category_info',$grocery_category_info);
        return view('admin.master')
                         ->with('admin.restaurant.grocery_category.grocery_categories',$manage_grocery_categories);
    }
    //ADD-GROCERY-CATEGORY
    public function add_grocery_category(){
        return view('admin.restaurant.grocery_category.add_grocery_category');
    }
    //SAVE GROCERY-CATEGORY TO DATABASE
    public function save_grocery_category(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:r3_grocery_categories'],
          'description'  => ['max:255'],

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('r3_grocery_categories')->insert($data);
        Session::put('message','Grocery Category is Added Successfully');
        return Redirect::to('/restaurant/grocery_category/add_grocery_category');
    }
    //EDIT GROCERY-CATEGORY
    public function edit_grocery_category($id)
    {
        $grocery_category=DB::table('r3_grocery_categories')
                           ->where('id',$id)
                           ->first();
        $manage_grocery_category=view('admin.restaurant.grocery_category.edit_grocery_category')
                         ->with('grocery_category',$grocery_category);
        return view('admin.master')
                         ->with('admin.restaurant.grocery_category.edit_grocery_category',$manage_grocery_category);
    }
    //UPDATE GROCERY-CATEGORY
    public function update_grocery_category(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('r3_grocery_categories')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Grocery Category has been updated Successfully');
        return Redirect::to('/restaurant/grocery_category/grocery_categories');
    }
    //DELETE GROCERY-CATEGORY FROM DATABASE
    public function delete_grocery_category($id)
    {
        DB::table('r3_grocery_categories')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Grocery Category has been deleted Successfully');
        return Redirect::to('/restaurant/grocery_category/grocery_categories');
    }



    //------- METHODS FOR GROCERY --------//
    //GROCERY
    public function grocery(){
        $grocery_info=DB::table('r4_groceries')
                            ->orderBy('id', 'desc')
                            ->get();
        $grocery_category_info=DB::table('r3_grocery_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_groceries=view('admin.restaurant.grocery.groceries')
                            ->with('grocery_info',$grocery_info)
                            ->with('grocery_category_info',$grocery_category_info);
        return view('admin.master')
                            ->with('admin.restaurant.grocery.groceries',$manage_groceries);
    }
    //ADD GROCERY
    public function add_grocery(){
        $grocery_category_info=DB::table('r3_grocery_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        return view('admin.restaurant.grocery.add_grocery')
                            ->with('grocery_category_info',$grocery_category_info);
    }
    //SAVE GROCERY TO DATABASE
    public function save_grocery(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:r4_groceries'],
          'grocery_category_id'  => ['required', 'integer'],
          'description'  => ['max:255'],

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['grocery_category_id'] = $request->grocery_category_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('r4_groceries')->insert($data);
        Session::put('message','Grocery is Added Successfully');
        return Redirect::to('/restaurant/grocery/add_grocery');
    }
    //EDIT GROCERY
    public function edit_grocery($id)
    {
        $grocery=DB::table('r4_groceries')
                           ->where('id',$id)
                           ->first();
        $grocery_category_info=DB::table('r3_grocery_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_grocery=view('admin.restaurant.grocery.edit_grocery')
                         ->with('grocery',$grocery)
                         ->with('grocery_category_info',$grocery_category_info);
        return view('admin.master')
                         ->with('admin.restaurant.grocery.edit_grocery',$manage_grocery);
    }
    //UPDATE GROCERY
    public function update_grocery(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'grocery_category_id'  => ['required', 'integer'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['grocery_category_id'] = $request->grocery_category_id;
        $data['description'] = $request->description;

        DB::table('r4_groceries')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Grocery has been updated Successfully');
        return Redirect::to('/restaurant/grocery/groceries');
    }
    //DELETE GROCERY FROM DATABASE
    public function delete_grocery($id)
    {
        DB::table('r4_groceries')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Grocery has been deleted Successfully');
        return Redirect::to('/restaurant/grocery/groceries');
    }



//------- METHODS FOR MEAL-ITEM-TYPE --------//
    //MEAL-ITEM-TYPE
    public function meal_item_type(){
        $meal_item_type_info=DB::table('r5_meal_types')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_meal_item_types=view('admin.restaurant.meal_item_type.meal_item_types')
                         ->with('meal_item_type_info',$meal_item_type_info);
        return view('admin.master')
                         ->with('admin.restaurant.meal_item_type.meal_item_types',$manage_meal_item_types);
    }
    //ADD-MEAL-ITEM-TYPE
    public function add_meal_item_type(){
        return view('admin.restaurant.meal_item_type.add_meal_item_type');
    }
    //SAVE MEAL-ITEM TO DATABASE
    public function save_meal_item_type(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:r5_meal_types'],
          'description'  => ['max:255']

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('r5_meal_types')->insert($data);
        Session::put('message','Meal Type is Added Successfully');
        return Redirect::to('/restaurant/meal_item_type/add_meal_item_type');
    }
    //EDIT MEAL-ITEM-TYPE
    public function edit_meal_item_type($id)
    {
        $meal_item_type=DB::table('r5_meal_types')
                           ->where('id',$id)
                           ->first();
        $manage_meal_item_type=view('admin.restaurant.meal_item_type.edit_meal_item_type')
                         ->with('meal_item_type',$meal_item_type);
        return view('admin.master')
                         ->with('admin.restaurant.meal_item_type.edit_meal_item_type',$manage_meal_item_type);
    }
    //UPDATE MEAL-ITEM-TYPE
    public function update_meal_item_type(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'description'  => [ 'max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('r5_meal_types')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Meal Type has been updated Successfully');
        return Redirect::to('/restaurant/meal_item_type/meal_item_types');
    }
    //DELETE MEAL-ITEM-TYPE FROM DATABASE
    public function delete_meal_item_type($id)
    {
        DB::table('r5_meal_types')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Meal Type has been deleted Successfully');
        return Redirect::to('/restaurant/meal_item_type/meal_item_types');
    }



//------- METHODS FOR MEAL-ITEM --------//
    //MEAL-ITEM
    public function meal_item(){
        $meal_item_info=DB::table('r6_meal_items')
                            ->orderBy('id', 'desc')
                            ->get();
        $meal_item_type_info=DB::table('r5_meal_types')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_meal_items=view('admin.restaurant.meal_item.meal_items')
                            ->with('meal_item_info',$meal_item_info)
                            ->with('meal_item_type_info',$meal_item_type_info);
        return view('admin.master')
                            ->with('admin.restaurant.meal_item.meal_items',$manage_meal_items);
    }
    //ADD-MEAL-ITEM
    public function add_meal_item(){
        $meal_item_type_info=DB::table('r5_meal_types')
                            ->orderBy('id', 'desc')
                            ->get();
        return view('admin.restaurant.meal_item.add_meal_item')
                            ->with('meal_item_type_info',$meal_item_type_info);
    }
    //SAVE MEAL-ITEM TO DATABASE
    public function save_meal_item(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:r6_meal_items'],
          'price'  => ['required', 'integer', 'min:0'],
          'meal_type_id'  => ['required', 'integer'],
          'description'  => ['max:255']

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['meal_type_id'] = $request->meal_type_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('r6_meal_items')->insert($data);
        Session::put('message','Meal Item is Added Successfully');
        return Redirect::to('/restaurant/meal_item/add_meal_item');
    }
    //EDIT MEAL-ITEM
    public function edit_meal_item($id)
    {
        $meal_item=DB::table('r6_meal_items')
                           ->where('id',$id)
                           ->first();
        $meal_item_type_info=DB::table('r5_meal_types')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_meal_item=view('admin.restaurant.meal_item.edit_meal_item')
                         ->with('meal_item',$meal_item)
                         ->with('meal_item_type_info',$meal_item_type_info);
        return view('admin.master')
                         ->with('admin.restaurant.meal_item.edit_meal_item',$manage_meal_item);
    }
    //UPDATE MEAL-ITEM
    public function update_meal_item(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'price'  => ['required', 'integer', 'min:0'],
          'meal_type_id'  => ['required', 'integer'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['meal_type_id'] = $request->meal_type_id;
        $data['description'] = $request->description;

        DB::table('r6_meal_items')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Meal Item has been updated Successfully');
        return Redirect::to('/restaurant/meal_item/meal_items');
    }
    //DELETE MEAL-ITEM FROM DATABASE
    public function delete_meal_item($id)
    {
        DB::table('r6_meal_items')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Meal Item has been deleted Successfully');
        return Redirect::to('/restaurant/meal_item/meal_items');
    }


//------- METHODS FOR MENU-TYPE --------//
    //MEAL-TYPE
    public function menu_type(){
        $menu_type_info=DB::table('r7_menu_types')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_menu_types=view('admin.restaurant.menu_type.menu_types')
                         ->with('menu_type_info',$menu_type_info);
        return view('admin.master')
                         ->with('admin.restaurant.menu_type.menu_types',$manage_menu_types);
    }
    //ADD MEAL-TYPE
    public function add_menu_type(){
        return view('admin.restaurant.menu_type.add_menu_type');
    }
    //SAVE MEAL-TYPE TO DATABASE
    public function save_menu_type(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:r7_menu_types'],
          'description'  => ['max:255'],

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('r7_menu_types')->insert($data);
        Session::put('message','Menu Type is Added Successfully');
        return Redirect::to('/restaurant/menu_type/add_menu_type');
    }
    //EDIT MEAL-TYPE
    public function edit_menu_type($id)
    {
        $menu_type=DB::table('r7_menu_types')
                           ->where('id',$id)
                           ->first();
        $manage_menu_type=view('admin.restaurant.menu_type.edit_menu_type')
                         ->with('menu_type',$menu_type);
        return view('admin.master')
                         ->with('admin.restaurant.menu_type.edit_menu_type',$manage_menu_type);
    }
    //UPDATE MEAL-TYPE
    public function update_menu_type(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('r7_menu_types')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Menu Type has been updated Successfully');
        return Redirect::to('/restaurant/menu_type/menu_types');
    }
    //DELETE MEAL-TYPE FROM DATABASE
    public function delete_menu_type($id)
    {
        DB::table('r7_menu_types')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Menu Type has been deleted Successfully');
        return Redirect::to('/restaurant/menu_type/menu_types');
    }


//------- METHODS FOR MENU --------//
    //MENU
    public function menu(){
        $menu_info=DB::table('r8_menus')
                           ->orderBy('id', 'desc')
                           ->get();
        $menu_type_info=DB::table('r7_menu_types')
                           ->orderBy('id', 'desc')
                           ->get();
        $item_info=DB::table('r6_meal_items')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_menus=view('admin.restaurant.menu.menus')
                         ->with('menu_info',$menu_info)
                         ->with('menu_type_info',$menu_type_info)
                         ->with('item_info',$item_info);
        return view('admin.master')
                         ->with('admin.restaurant.menu.menus',$manage_menus);
    }
    //ADD MENU
    public function add_menu(){

        $menu_type_info = DB::table('r7_menu_types')
                            ->orderBy('id','desc')
                            ->get();
        $meal_item_info = DB::table('r6_meal_items')
                            ->orderBy('id','desc')
                            ->get();

        $manage_menu = view('admin.restaurant.menu.add_menu')
                            ->with('menu_type_info',$menu_type_info)
                            ->with('meal_item_info',$meal_item_info);

        return view('admin.master')
                        ->with('admin.restaurant.menu.add_menu',$manage_menu);
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('r6_meal_items')
            //->select('price')
            ->where('id', $value)
            ->get();
        foreach($data as $row)
        {
            // $output = '<p>'.$row->price.'</p>';
            $output = $row->price;
        }
        //$output = $data;
        echo $output;
    }


    //SAVE MENU TO DATABASE
    public function save_menu(Request $request)
    {
        $this->validate($request, [
          'name'          => ['required', 'string', 'max:100','unique:r8_menus'],
          'price'         => ['required', 'integer', 'min:0'],
          'menu_type_id'  => ['required', 'integer', 'min:0'],
          'description'   => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['menu_type_id'] = $request->menu_type_id;
        $data['item_1_id'] = $request->item_1_id;
        $data['item_1_quantity'] = $request->item_1_quantity;
        $data['item_2_id'] = $request->item_2_id;
        $data['item_2_quantity'] = $request->item_2_quantity;
        $data['item_3_id'] = $request->item_3_id;
        $data['item_3_quantity'] = $request->item_3_quantity;
        $data['item_4_id'] = $request->item_4_id;
        $data['item_4_quantity'] = $request->item_4_quantity;
        $data['item_5_id'] = $request->item_5_id;
        $data['item_5_quantity'] = $request->item_5_quantity;
        $data['item_6_id'] = $request->item_6_id;
        $data['item_6_quantity'] = $request->item_6_quantity;
        $data['item_7_id'] = $request->item_7_id;
        $data['item_7_quantity'] = $request->item_7_quantity;
        $data['item_8_id'] = $request->item_8_id;
        $data['item_8_quantity'] = $request->item_8_quantity;
        $data['item_9_id'] = $request->item_9_id;
        $data['item_9_quantity'] = $request->item_9_quantity;
        $data['item_10_id'] = $request->item_10_id;
        $data['item_10_quantity'] = $request->item_10_quantity;
        $data['description'] = $request->description;
        $data['created_at'] = now();


        DB::table('r8_menus')->insert($data);
        Session::put('message','Menu is Added Successfully');
        return Redirect::to('/restaurant/menu/add_menu');
    }
    //EDIT MENU
    public function edit_menu($id)
    {
        $menu=DB::table('r8_menus')
                           ->where('id',$id)
                           ->first();
        $menu_type_info=DB::table('r7_menu_types')
                           ->get();
        $item_info=DB::table('r6_meal_items')
                           ->get();

        $manage_menu=view('admin.restaurant.menu.edit_menu')
                         ->with('menu',$menu)
                         ->with('menu_type_info',$menu_type_info)
                         ->with('item_info',$item_info);
        return view('admin.master')
                         ->with('admin.restaurant.menu.edit_menu',$manage_menu);
    }
    //UPDATE MENU
    public function update_menu(Request $request, $id)
    {
        $this->validate($request, [
          'name'          => ['required', 'string', 'max:100'],
          'price'         => ['required', 'integer', 'min:0'],
          'menu_type_id'  => ['required', 'integer', 'min:0'],
          'description'   => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['menu_type_id'] = $request->menu_type_id;
        $data['item_1_id'] = $request->item_1_id;
        $data['item_1_quantity'] = $request->item_1_quantity;
        $data['item_2_id'] = $request->item_2_id;
        $data['item_2_quantity'] = $request->item_2_quantity;
        $data['item_3_id'] = $request->item_3_id;
        $data['item_3_quantity'] = $request->item_3_quantity;
        $data['item_4_id'] = $request->item_4_id;
        $data['item_4_quantity'] = $request->item_4_quantity;
        $data['item_5_id'] = $request->item_5_id;
        $data['item_5_quantity'] = $request->item_5_quantity;
        $data['item_6_id'] = $request->item_6_id;
        $data['item_6_quantity'] = $request->item_6_quantity;
        $data['item_7_id'] = $request->item_7_id;
        $data['item_7_quantity'] = $request->item_7_quantity;
        $data['item_8_id'] = $request->item_8_id;
        $data['item_8_quantity'] = $request->item_8_quantity;
        $data['item_9_id'] = $request->item_9_id;
        $data['item_9_quantity'] = $request->item_9_quantity;
        $data['item_10_id'] = $request->item_10_id;
        $data['item_10_quantity'] = $request->item_10_quantity;
        $data['description'] = $request->description;

        DB::table('r8_menus')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Menu has been updated Successfully');
        return Redirect::to('/restaurant/menu/menus');
    }
    //DELETE MENU FROM DATABASE
    public function delete_menu($id)
    {
        DB::table('r8_menus')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Menu has been deleted Successfully');
        return Redirect::to('/restaurant/menu/menus');
    }
}
