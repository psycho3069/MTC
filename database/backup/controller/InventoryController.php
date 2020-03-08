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


class InventoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


//------- METHODS FOR INVENTORY-SUPPLIER --------//
    //INVENTORY-SUPPLIER
    public function inventory_supplier(){
        $inventory_supplier_info=DB::table('i1_inventory_suppliers')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_inventory_suppliers=view('admin.inventory.inventory_supplier.inventory_suppliers')
                         ->with('inventory_supplier_info',$inventory_supplier_info);
        return view('admin.master')
                         ->with('admin.inventory.inventory_supplier.inventory_suppliers',$manage_inventory_suppliers);
    }
    //ADD SUPPLIER
    public function add_inventory_supplier(){
        return view('admin.inventory.inventory_supplier.add_inventory_supplier');
    }
    //SAVE SUPPLIER TO DATABASE
    public function save_inventory_supplier(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:i1_inventory_suppliers'],
          'address'  => ['required', 'string', 'max:100'],
          'phone_no'  => ['required', 'max:20']

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone_no'] = $request->phone_no;
        $data['created_at'] = now();

        DB::table('i1_inventory_suppliers')->insert($data);
        Session::put('message','Inventory Supplier is Added Successfully');
        return Redirect::to('/inventory/inventory_supplier/add_inventory_supplier');
    }
    //EDIT SUPPLIER
    public function edit_inventory_supplier($id)
    {
        $inventory_supplier=DB::table('i1_inventory_suppliers')
                           ->where('id',$id)
                           ->first();
        $manage_inventory_supplier=view('admin.inventory.inventory_supplier.edit_inventory_supplier')
                         ->with('inventory_supplier',$inventory_supplier);
        return view('admin.master')
                         ->with('admin.inventory.inventory_supplier.edit_inventory_supplier',$manage_inventory_supplier);
    }
    //UPDATE SUPPLIER
    public function update_inventory_supplier(Request $request, $id)
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

        DB::table('i1_inventory_suppliers')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Supplier has been updated Successfully');
        return Redirect::to('/inventory/inventory_supplier/inventory_suppliers');
    }
    //DELETE SUPPLIER FROM DATABASE
    public function delete_inventory_supplier($id)
    {
        DB::table('i1_inventory_suppliers')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Supplier has been deleted Successfully');
        return Redirect::to('/inventory/inventory_supplier/inventory_suppliers');
    }


//------- METHODS FOR INVENTORY-RECEIVER --------//
    //RECEIVER
    public function inventory_receiver(){
        $inventory_receiver_info=DB::table('i2_inventory_receivers')
                           ->orderBy('id', 'desc')
                           ->get();
        $employee_info=DB::table('e4_employees')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_inventory_receivers=view('admin.inventory.inventory_receiver.inventory_receivers')
                         ->with('inventory_receiver_info',$inventory_receiver_info)
                         ->with('employee_info',$employee_info);
        return view('admin.master')
                         ->with('admin.inventory.inventory_receiver.inventory_receivers',$manage_inventory_receivers);
    }
    //ADD-RECEIVER
    public function add_inventory_receiver(){
        $employee_info=DB::table('e4_employees')
                           ->orderBy('id', 'desc')
                           ->get();
        return view('admin.inventory.inventory_receiver.add_inventory_receiver')
                          ->with('employee_info',$employee_info);
    }
    //SAVE RECEIVER TO DATABASE
    public function save_inventory_receiver(Request $request)
    {
        $this->validate($request, [
          'employee_id'  => ['required', 'integer', 'unique:i2_inventory_receivers']
        ]);
        $data = array();
        $data['employee_id'] = $request->employee_id;
        $data['created_at'] = now();

        DB::table('i2_inventory_receivers')->insert($data);
        Session::put('message','Receiver is Added Successfully');
        return Redirect::to('/inventory/inventory_receiver/add_inventory_receiver');
    }
    //DELETE RECEIVER FROM DATABASE
    public function delete_inventory_receiver($id)
    {
        DB::table('i2_inventory_receivers')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Receiver has been deleted Successfully');
        return Redirect::to('/inventory/inventory_receiver/add_inventory_receiver');
    }


//------- METHODS FOR INVENTORY-CATEGORY --------//
    //INVENTORY-CATEGORY
    public function inventory_category(){
        $inventory_category_info=DB::table('i3_inventory_categories')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_inventory_categories=view('admin.inventory.inventory_category.inventory_categories')
                         ->with('inventory_category_info',$inventory_category_info);
        return view('admin.master')
                         ->with('admin.inventory.inventory_category.inventory_categories',$manage_inventory_categories);
    }
    //ADD-INVENTORY-CATEGORY
    public function add_inventory_category(){
        return view('admin.inventory.inventory_category.add_inventory_category');
    }
    //SAVE INVENTORY-CATEGORY TO DATABASE
    public function save_inventory_category(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:i3_inventory_categories'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('i3_inventory_categories')->insert($data);
        Session::put('message','Inventory Category is Added Successfully');
        return Redirect::to('/inventory/inventory_category/add_inventory_category');
    }
    //EDIT INVENTORY-CATEGORY
    public function edit_inventory_category($id)
    {
        $inventory_category=DB::table('i3_inventory_categories')
                           ->where('id',$id)
                           ->first();
        $manage_inventory_category=view('admin.inventory.inventory_category.edit_inventory_category')
                         ->with('inventory_category',$inventory_category);
        return view('admin.master')
                         ->with('admin.inventory.inventory_category.edit_inventory_category',$manage_inventory_category);
    }
    //UPDATE INVENTORY-CATEGORY
    public function update_inventory_category(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('i3_inventory_categories')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Inventory Category has been updated Successfully');
        return Redirect::to('/inventory/inventory_category/inventory_categories');
    }
    //DELETE INVENTORY-CATEGORY FROM DATABASE
    public function delete_inventory_category($id)
    {
        DB::table('i3_inventory_categories')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Inventory Category has been deleted Successfully');
        return Redirect::to('/inventory/inventory_category/inventory_categories');
    }


//------- METHODS FOR INVENTORY --------//
    //INVENTORY
    public function inventory_item(){
        $inventory_item_info=DB::table('i4_inventories')
                            ->orderBy('id', 'desc')
                            ->get();
        $inventory_category_info=DB::table('i3_inventory_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_inventories=view('admin.inventory.inventory_item.inventory_items')
                            ->with('inventory_item_info',$inventory_item_info)
                            ->with('inventory_category_info',$inventory_category_info);
        return view('admin.master')
                            ->with('admin.inventory.inventory_item.inventory_items',$manage_inventories);
    }
    //ADD INVENTORY
    public function add_inventory_item(){
        $inventory_category_info=DB::table('i3_inventory_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        return view('admin.inventory.inventory_item.add_inventory_item')
                            ->with('inventory_category_info',$inventory_category_info);
    }
    //SAVE INVENTORY TO DATABASE
    public function save_inventory_item(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:i4_inventories'],
          'inventory_category_id'  => ['required', 'integer'],
          'description'  => ['max:255'],

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['inventory_category_id'] = $request->inventory_category_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('i4_inventories')->insert($data);
        Session::put('message','Inventory Item is Added Successfully');
        return Redirect::to('/inventory/inventory_item/add_inventory_item');
    }
    //EDIT INVENTORY
    public function edit_inventory_item($id)
    {
        $inventory_item=DB::table('i4_inventories')
                           ->where('id',$id)
                           ->first();
        $inventory_category_info=DB::table('i3_inventory_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_inventory_item=view('admin.inventory.inventory_item.edit_inventory_item')
                         ->with('inventory_item',$inventory_item)
                         ->with('inventory_category_info',$inventory_category_info);
        return view('admin.master')
                         ->with('admin.inventory.inventory_item.edit_inventory_item',$manage_inventory_item);
    }
    //UPDATE INVENTORY
    public function update_inventory_item(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'inventory_category_id'  => ['required', 'integer'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['inventory_category_id'] = $request->inventory_category_id;
        $data['description'] = $request->description;

        DB::table('i4_inventories')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Inventory Item has been updated Successfully');
        return Redirect::to('/inventory/inventory_item/inventory_items');
    }
    //DELETE INVENTORY FROM DATABASE
    public function delete_inventory_item($id)
    {
        DB::table('i4_inventories')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Inventory Item has been deleted Successfully');
        return Redirect::to('/inventory/inventory_item/inventory_items');
    }

}
