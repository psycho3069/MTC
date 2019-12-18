<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\MisAccountHead;
use App\RoomBilling;
use App\RoomBooking;
use App\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\CustomTrait;
use DB;
use PDF;
use Auth;
use Session;
use Exception;
use DateTime;

class HotelController extends Controller
{
    use CustomTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //------- METHODS FOR BUILDING --------//
    //BUILDING
    public function building(){
        $all_buildings_info=DB::table('h2_buildings')
                           ->orderBy('id', 'desc')
                           ->get();
        $building_type_info=DB::table('h1_building_types')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_buildings=view('admin.hotel_management.building.building_list')
                         ->with('all_buildings_info',$all_buildings_info)
                         ->with('building_type_info',$building_type_info);
        return view('admin.master')
                         ->with('admin.hotel_management.building.building_list',$manage_buildings);
    }
    //ADD-BUILDING
    public function add_building(){

        $building_type_info = DB::table('h1_building_types')
                            ->orderBy('id','desc')
                            ->get();
        $manage_building_type = view('admin.hotel_management.building.addbuilding')
                            ->with('building_type_info',$building_type_info);

        return view('admin.master')
                        ->with('admin.hotel_management.building.addbuilding',$manage_building_type);
    }
    //SAVE BUILDING TO DATABASE
    public function save_building(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:h2_buildings'],
          'type_id' => ['required'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['building_type'] = $request->type_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();


        DB::table('h2_buildings')->insert($data);
        Session::put('message','Building is Added Successfully');
        return Redirect::to('/hotel_management/building/addbuilding');
    }
    //EDIT BUILDING
    public function edit_building($id)
    {
        $building_info=DB::table('h2_buildings')
                           ->where('id',$id)
                           ->first();
        $building_type_info_prev=DB::table('h1_building_types')
                           ->where('id',$id)
                           ->first();
        $building_type_info_all=DB::table('h1_building_types')
                           ->get();

        $manage_building=view('admin.hotel_management.building.editbuilding')
                         ->with('building_info',$building_info)
                         ->with('building_type_info_prev',$building_type_info_prev)
                         ->with('building_type_info_all',$building_type_info_all);
        return view('admin.master')
                         ->with('admin.hotel_management.building.editbuilding',$manage_building);
    }
    //UPDATE BUILDING
    public function update_building(Request $request, $id)
    {

        $this->validate($request, [
          'name'  => 'required', 'string', 'max:100','unique:h2_buildings,name'.$id,
          'type_id' => ['required'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['building_type'] = $request->type_id;
        $data['description'] = $request->description;

        DB::table('h2_buildings')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Building has been updated Successfully');
        return Redirect::to('/hotel_management/building/building_list');
    }
    //DELETE BUILDING FROM DATABASE
    public function delete_building($id)
    {
        try {
            DB::table('h2_buildings')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Building has been deleted Successfully');
        return Redirect::to('/hotel_management/building/building_list');
        } catch (Exception $e) {
            return back()->withError('This Building cannot be deleted because other Floor/Floors depend on it. To delete this Building, delete dependent Floor/Floors first, only then you can delete it.');
        }
    }

    //------- METHODS FOR BUILDING-TYPE --------//
    //BUILDING-TYPE
    public function building_type(){
        $building_type_list_info=DB::table('h1_building_types')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_building_types=view('admin.hotel_management.building.building_type_list')
                         ->with('building_type_list_info',$building_type_list_info);
        return view('admin.master')
                         ->with('admin.hotel_management.building.building_type_list',$manage_building_types);
    }
    //ADD BUILDING-TYPE
    public function add_building_type(){

        return view('admin.hotel_management.building.addbuildingtype');
    }
    //SAVE BUILDING-TYPE TO DATABASE
    public function save_building_type(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:h1_building_types'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('h1_building_types')->insert($data);
        Session::put('message','Building Type is Added Successfully');
        return Redirect::to('/hotel_management/building/addbuildingtype');
    }
    //EDIT BUILDING-TYPE
    public function edit_building_type($id)
    {
        $building_type_info=DB::table('h1_building_types')
                           ->where('id',$id)
                           ->first();

        $manage_building=view('admin.hotel_management.building.editbuildingtype')
                         ->with('building_type_info',$building_type_info);
        return view('admin.master')
                         ->with('admin.hotel_management.building.editbuildingtype',$manage_building);
    }
    //UPDATE BUILDING-TYPE
    public function update_building_type(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => 'required', 'string', 'max:100','unique:h1_building_types,name'.$id,
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('h1_building_types')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Building Type has been updated Successfully');
        return Redirect::to('/hotel_management/building/building_type_list');
    }
    //DELETE BUILDING-TYPE FROM DATABASE
    public function delete_building_type($id)
    {
        try {
            DB::table('h1_building_types')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Building Type has been deleted Successfully');
        return Redirect::to('/hotel_management/building/building_type_list');
        } catch (Exception $e) {
            return back()->withError('This Building Type cannot be deleted because other Building/Buildings depend on it. To delete this Building Type, delete dependent Building/Buildings first, only then you can delete it.');
        }
    }


    //------- METHODS FOR FLOOR --------//
    //FLOOR
    public function floor(){
        $floors_info=DB::table('h4_floors')
                           ->orderBy('id', 'desc')
                           ->get();
        $floor_type_info=DB::table('h3_floor_types')
                           ->orderBy('id', 'desc')
                           ->get();
        $building_info=DB::table('h2_buildings')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_floors=view('admin.hotel_management.floor.floor_list')
                         ->with('floors_info',$floors_info)
                         ->with('floor_type_info',$floor_type_info)
                         ->with('building_info',$building_info);
        return view('admin.master')
                         ->with('admin.hotel_management.floor.floor_list',$manage_floors);
    }
    //ADD FLOOR
    public function add_floor(){

        $floor_type_info = DB::table('h3_floor_types')
                            ->orderBy('id','desc')
                            ->get();
        $building_info = DB::table('h2_buildings')
                            ->orderBy('id','desc')
                            ->get();

        $manage_floor = view('admin.hotel_management.floor.addfloor')
                            ->with('building_info',$building_info)
                            ->with('floor_type_info',$floor_type_info);

        return view('admin.master')
                        ->with('admin.hotel_management.floor.addfloor',$manage_floor);
    }
    //SAVE FLOOR TO DATABASE
    public function save_floor(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:h4_floors'],
          'building_id' => ['required'],
          'type_id' => ['required'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['building_id'] = $request->building_id;
        $data['floor_type'] = $request->type_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();


        DB::table('h4_floors')->insert($data);
        Session::put('message','Floor is Added Successfully');
        return Redirect::to('/hotel_management/floor/addfloor');
    }
    //EDIT FLOOR
    public function edit_floor($id)
    {
        $floor_info=DB::table('h4_floors')
                           ->where('id',$id)
                           ->first();
        $floor_type_info_prev=DB::table('h3_floor_types')
                           ->where('id',$id)
                           ->first();
        $floor_type_info_all=DB::table('h3_floor_types')
                           ->get();
        $building_info_all=DB::table('h2_buildings')
                           ->get();

        $manage_floor=view('admin.hotel_management.floor.editfloor')
                         ->with('floor_info',$floor_info)
                         ->with('floor_type_info_prev',$floor_type_info_prev)
                         ->with('floor_type_info_all',$floor_type_info_all)
                         ->with('building_info_all',$building_info_all);
        return view('admin.master')
                         ->with('admin.hotel_management.floor.editfloor',$manage_floor);
    }
    //UPDATE FLOOR
    public function update_floor(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => 'required', 'string', 'max:100','unique:h4_floors,name'.$id,
          'type_id' => 'required',
          'building_id' => 'required',
          'description'  => 'max:255'
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['floor_type'] = $request->type_id;
        $data['building_id'] = $request->building_id;
        $data['description'] = $request->description;

        DB::table('h4_floors')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Floor has been updated Successfully');
        return Redirect::to('/hotel_management/floor/floor_list');
    }
    //DELETE FLOOR FROM DATABASE
    public function delete_floor($id)
    {
        try {
            DB::table('h4_floors')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Floor has been deleted Successfully');
        return Redirect::to('/hotel_management/floor/floor_list');
        } catch (Exception $e) {
            return back()->withError('This Floor cannot be deleted because other Room/Rooms depend on it. To delete this Floor, delete dependent Room/Rooms first, only then you can delete it.');
        }
    }


    //------- METHODS FOR FLOOR-TYPE --------//
    //FLOOR-TYPE
    public function floor_type(){
        $floor_type_list_info=DB::table('h3_floor_types')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_floor_types=view('admin.hotel_management.floor.floor_type_list')
                         ->with('floor_type_list_info',$floor_type_list_info);
        return view('admin.master')
                         ->with('admin.hotel_management.floor.floor_type_list',$manage_floor_types);
    }
    //ADD-FLOOR-TYPE
    public function add_floor_type(){

        return view('admin.hotel_management.floor.addfloortype');
    }
    //SAVE FLOOR-TYPE TO DATABASE
    public function save_floor_type(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:h3_floor_types'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('h3_floor_types')->insert($data);
        Session::put('message','Floor Type is Added Successfully');
        return Redirect::to('/hotel_management/floor/addfloortype');
    }
    //EDIT FLOOR-TYPE
    public function edit_floor_type($id)
    {
        $floor_type_info=DB::table('h3_floor_types')
                           ->where('id',$id)
                           ->first();

        $manage_floor=view('admin.hotel_management.floor.editfloortype')
                         ->with('floor_type_info',$floor_type_info);
        return view('admin.master')
                         ->with('admin.hotel_management.floor.editfloortype',$manage_floor);
    }
    //UPDATE FLOOR-TYPE
    public function update_floor_type(Request $request, $id)
    {

        $this->validate($request, [
          'name'  => 'required', 'string', 'max:100','unique:h3_floor_types,name'.$id,
          'description'  => 'max:255'
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('h3_floor_types')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Floor Type has been updated Successfully');
        return Redirect::to('/hotel_management/floor/floor_type_list');
    }
    //DELETE FLOOR-TYPE FROM DATABASE
    public function delete_floor_type($id)
    {
        try {
            DB::table('h3_floor_types')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Floor Type has been deleted Successfully');
        return Redirect::to('/hotel_management/floor/floor_type_list');
        } catch (Exception $e) {
            return back()->withError('This Floor Type cannot be deleted because other Floor/Floors depend on it. To delete this Floor Type, delete dependent Floor/Floors first, only then you can delete it.');
        }
    }


    //------- METHODS FOR ROOM --------//

    //ROOM
    public function room(){
        $rooms_info=DB::table('h6_rooms')
                           ->orderBy('id', 'desc')
                           ->get();
        $room_category_info=DB::table('h5_room_categories')
                           ->orderBy('id', 'desc')
                           ->get();
        $floor_info=DB::table('h4_floors')
                           ->orderBy('id', 'desc')
                           ->get();
        $building_info=DB::table('h2_buildings')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_rooms=view('admin.hotel_management.room.room_list')
                         ->with('floor_info',$floor_info)
                         ->with('rooms_info',$rooms_info)
                         ->with('room_category_info',$room_category_info)
                         ->with('building_info',$building_info);
        return view('admin.master')
                         ->with('admin.hotel_management.room.room_list',$manage_rooms);
    }

    //ADD ROOM
    public function add_room(){

        $room_category_info = DB::table('h5_room_categories')
                            ->orderBy('id','desc')
                            ->get();
        $building_info = DB::table('h2_buildings')
                            ->orderBy('id','desc')
                            ->get();
        $floor_info = DB::table('h4_floors')
                            ->orderBy('id','desc')
                            ->get();

        $manage_room = view('admin.hotel_management.room.addroom')
                            ->with('building_info',$building_info)
                            ->with('floor_info',$floor_info)
                            ->with('room_category_info',$room_category_info);

        return view('admin.master')
                        ->with('admin.hotel_management.room.addroom',$manage_room);
    }
    //SAVE ROOM TO DATABASE
    public function save_room(Request $request)
    {
        $this->validate($request, [
          'room_no'  => ['required', 'string', 'max:100','unique:h6_rooms,room_no'],
          'price'  => ['required', 'integer', 'min:0'],
          'capacity'  => ['required', 'integer', 'min:0'],
          'floor_id' => ['required', 'integer'],
          'type_id' => ['required', 'integer'],
          'image' => 'required|image|mimes:jpeg,png,jpg,JPG|dimensions:width=700,height=438',
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['room_no'] = $request->room_no;
        $data['price'] = $request->price;
        $data['persons_capacity'] = $request->capacity;
        $data['category_id'] = $request->type_id;
        $data['floor_id'] = $request->floor_id;
        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $original_name=$request->file('image')->getClientOriginalName();
            $image = str_random(3) . '_' . $original_name;
            $destinationPath = public_path() . '/uploads/rooms_image/';
            $file->move($destinationPath, $image);
            $data['image'] = $image;
        }

        $data['created_at'] = now();


        DB::table('h6_rooms')->insert($data);
        Session::put('message','Room is Added Successfully');
        return Redirect::to('/hotel_management/room/addroom');
    }
    //EDIT ROOM
    public function edit_room($id)
    {
        $room_info=DB::table('h6_rooms')
                           ->where('id',$id)
                           ->first();
        $room_category_info_prev=DB::table('h5_room_categories')
                           ->where('id',$id)
                           ->first();
        $room_category_info_all=DB::table('h5_room_categories')
                           ->get();
        $floor_info_all=DB::table('h4_floors')
                           ->get();

        $manage_room=view('admin.hotel_management.room.editroom')
                         ->with('room_info',$room_info)
                         ->with('room_category_info_prev',$room_category_info_prev)
                         ->with('room_category_info_all',$room_category_info_all)
                         ->with('floor_info_all',$floor_info_all);
        return view('admin.master')
                         ->with('admin.hotel_management.room.editroom',$manage_room);
    }
    //UPDATE ROOM
    public function update_room(Request $request, $id)
    {
        $this->validate($request, [
          'room_no'  => 'required', 'string', 'max:100','unique:h6_rooms,room_no'.$id,
          'type_id' => 'required',
          'price' => 'required','integer', 'min:0',
          'capacity' => 'required','integer', 'min:0',
          'floor_id' => 'required',
          'image' => 'mimes:jpeg,png,jpg,JPG|dimensions:width=700,height=438',
          'description'  => 'max:255'
        ]);

        $table = DB::table('h6_rooms')->find($id);

        $data = array();
        $data['room_no'] = $request->room_no;
        $data['category_id'] = $request->type_id;
        $data['price'] = $request->price;
        $data['persons_capacity'] = $request->capacity;
        $data['floor_id'] = $request->floor_id;
        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $full_path=public_path() . '/uploads/rooms_image/'.$table->image;
            if (file_exists($full_path)) {
                unlink($full_path);
            }
            $file = $request->file('image');
            $original_name=$request->file('image')->getClientOriginalName();
            $image = str_random(3) . '_' . $original_name;
            $destinationPath = public_path() . '/uploads/rooms_image/';
            $file->move($destinationPath, $image);
            $data['image'] = $image;
        }

        DB::table('h6_rooms')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Room has been updated Successfully');
        return Redirect::to('/hotel_management/room/room_list');
    }
    //DELETE ROOM FROM DATABASE
    public function delete_room($id)
    {
        try {
            $table = DB::table('h6_rooms')->find($id);

            $full_path=public_path() . '/uploads/rooms_image/'.$table->image;
            if (file_exists($full_path)) {
                unlink($full_path);
            }

            DB::table('h6_rooms')
                ->where('id',$id)
                ->delete();


        Session::put('message', 'Room has been deleted Successfully');
        return Redirect::to('/hotel_management/room/room_list');
        } catch (Exception $e) {
            return back()->withError('This Room cannot be deleted because other Reservation/Reservations depend on it. To delete this Room, delete dependent Reservation/Reservations first, only then you can delete it.');
        }
    }


    //------- METHODS FOR ROOM-CATEGORY --------//
    //ROOM-CATEGORY
    public function room_category(){
        $room_category_list_info=DB::table('h5_room_categories')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_room_category=view('admin.hotel_management.room.room_category_list')
                         ->with('room_category_list_info',$room_category_list_info);
        return view('admin.master')
                         ->with('admin.hotel_management.room.room_category_list',$manage_room_category);
    }
    //ADD ROOM-CATEGORY
    public function add_room_category(){

        return view('admin.hotel_management.room.addroomcategory');
    }
    //SAVE ROOM-CATEGORY TO DATABASE
    public function save_room_category(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100', 'unique:h5_room_categories'],
          'price'  => ['required', 'integer', 'min:0'],
          'vat'  => ['required', 'integer', 'min:0'],
          'image' => 'mimes:jpeg,png,jpg,JPG|dimensions:width=700,height=438',
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['vat'] = $request->vat;
        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $original_name=$request->file('image')->getClientOriginalName();
            $image = str_random(3) . '_' . $original_name;
            $destinationPath = public_path() . '/uploads/rooms_category_image/';
            $file->move($destinationPath, $image);
            $data['image'] = $image;
        }

        $data['created_at'] = now();

        DB::table('h5_room_categories')->insert($data);
        Session::put('message','Room Category is Added Successfully');
        return Redirect::to('/hotel_management/room/addroomcategory');
    }
    //EDIT ROOM-CATEGORY
    public function edit_room_category($id)
    {
        $room_category_info=DB::table('h5_room_categories')
                           ->where('id',$id)
                           ->first();

        $manage_room_category=view('admin.hotel_management.room.editroomcategory')
                         ->with('room_category_info',$room_category_info);
        return view('admin.master')
                         ->with('admin.hotel_management.room.editroomcategory',$manage_room_category);
    }
    //UPDATE ROOM-CATEGORY
    public function update_room_category(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => 'required', 'string', 'max:100','unique:h5_room_categories,name'.$id,
          'image' => 'mimes:jpeg,png,jpg,JPG|dimensions:width=700,height=438',
          'description'  => ['max:255']
        ]);

        $table = DB::table('h5_room_categories')->find($id);

        $data = array();
        $data['name'] = $request->name;

        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $full_path=public_path() . '/uploads/rooms_category_image/'.$table->image;
            if (file_exists($full_path)) {
                unlink($full_path);
            }

            $file = $request->file('image');
            $original_name=$request->file('image')->getClientOriginalName();
            $image = str_random(3) . '_' . $original_name;
            $destinationPath = public_path() . '/uploads/rooms_category_image/';
            $file->move($destinationPath, $image);
            $data['image'] = $image;
        }

        DB::table('h5_room_categories')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Room Category has been updated Successfully');
        return Redirect::to('/hotel_management/room/room_category_list');
    }
    //DELETE ROOM-CATEGORY FROM DATABASE
    public function delete_room_category($id)
    {
        try {

            $table = DB::table('h5_room_categories')->find($id);

            $full_path=public_path() . '/uploads/rooms_category_image/'.$table->image;
            if (file_exists($full_path)) {
                unlink($full_path);
            }

            DB::table('h5_room_categories')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Room Category has been deleted Successfully');
        return Redirect::to('/hotel_management/room/room_category_list');
        } catch (Exception $e) {
            return back()->withError('This Room Category cannot be deleted because other Room/Rooms depend on it. To delete this Room Category, delete dependent Room/Rooms first, only then you can delete it.');
        }
    }



    //------- METHODS FOR ROOM-RESERVATION --------//
    //ROOM-RESERVATION


    // delete automatically
    public function automaticallyDelete()
    {
        $date = new DateTime;
        $date->modify('-6 hours');
        $formatted = $date->format('Y-m-d H:i:s');

        DB::table('h7_room_reservations')->where('created_at', '<=', $formatted)->where('status', '=', 1)->delete();

        $room_reservation_info=DB::table('h7_room_reservations')
            ->orderBy('id', 'desc')
            ->get();
        $room_info=DB::table('h6_rooms')
            ->orderBy('id', 'desc')
            ->get();
        $manage_room_reservation=view('admin.hotel_management.reservation.room_reservation_list')
            ->with('room_reservation_info',$room_reservation_info)
            ->with('room_info',$room_info);
        return view('admin.master')
            ->with('admin.hotel_management.reservation.room_reservation_list',$manage_room_reservation);
    }

    
    //VIEW ROOM-RESERVATION
    public function view_reservation($id){
        $reservation=DB::table('h7_room_reservations')
                           ->where('id',$id)
                           ->first();
        $room_info=DB::table('h6_rooms')
                            ->get();
        $manage_reservation_view=view('admin.hotel_management.reservation.viewreservation')
                            ->with('reservation',$reservation)
                            ->with('room_info',$room_info);
        return view('admin.master')
                         ->with('admin.hotel_management.reservation.viewreservation',$manage_reservation_view);
    }
    //EDIT ROOM-RESERVATION
    public function edit_reservation($id)
    {
        $reservation_info=DB::table('h7_room_reservations')
                           ->where('id',$id)
                           ->first();
        $room_info=DB::table('h6_rooms')
                           ->get();
        $room_category = DB::table('h5_room_categories')
            ->get();

        $manage_reservation=view('admin.hotel_management.reservation.editreservation')
                         ->with('reservation_info',$reservation_info)
                         ->with('room_info',$room_info)
                         ->with('room_category',$room_category );
        return view('admin.master')
                         ->with('admin.hotel_management.reservation.editreservation',$manage_reservation);
    }
    //UPDATE ROOM-RESERVATION
    public function update_reservation(Request $request, $id)
    {
        $this->validate($request, [
          'org_name'  => 'required',
          'guest_name'  => 'required', 'string', 'max:100','unique:h7_room_reservations,guest_name'.$id,
          'guest_contact'  => 'required',
          'start_date'  => 'required','date',
          // 'end_date' => ['date'],
          'room_id' => 'required', 'integer',
          'status'  => 'required', 'max:5'
        ]);

        $data = array();
        $data['org_name'] = $request->org_name;
        $data['guest_name'] = $request->guest_name;
        $data['guest_contact'] = $request->guest_contact;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['room_id'] = $request->room_id;
        $data['status'] = $request->status;

        DB::table('h7_room_reservations')
                ->where('id',$id)
                ->update($data);
        Session::put('message','Room Reservation has been updated Successfully');
        return Redirect::to('/hotel_management/reservation/room_reservation_list');
    }
    //DELETE ROOM-RESERVATION FROM DATABASE
    public function delete_reservation($id)
    {
        DB::table('h7_room_reservations')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Room Reservation has been deleted Successfully');
        return Redirect::to('/hotel_management/reservation/room_reservation_list');
    }



    //------- METHODS FOR ROOM-BOOKING --------//
    //ROOM-BOOKING
    public function room_booking(){
        $booking_info=DB::table('h8_room_bookings')
                            ->orderBy('id', 'desc')
                            ->get();
        $billing_info=DB::table('h9_room_billings')
                            ->orderBy('id', 'desc')
                            ->get();
        $room_info=DB::table('h6_rooms')
                            ->get();
        $manage_room_booking=view('admin.hotel_management.booking.booking_list')
                            ->with('booking_info',$booking_info)
                            ->with('billing_info',$billing_info)
                            ->with('room_info',$room_info);
        return view('admin.master')
                         ->with('admin.hotel_management.booking.booking_list',$manage_room_booking);
    }
    
    //VIEW ROOM-BOOKING
    public function view_booking($id){
        $booking=DB::table('h8_room_bookings')
                           ->where('id',$id)
                           ->first();
        $room_info=DB::table('h6_rooms')
                            ->get();
        $manage_booking_view=view('admin.hotel_management.booking.viewbooking')
                            ->with('booking',$booking)
                            ->with('room_info',$room_info);
        return view('admin.master')
                         ->with('admin.hotel_management.booking.viewbooking',$manage_booking_view);
    }
    //EDIT ROOM-BOOKING
    public function edit_booking($id)
    {
        $booking=DB::table('h8_room_bookings')
                           ->where('id',$id)
                           ->first();
        $room_info=DB::table('h6_rooms')
                           ->get();

        $room_category = DB::table('h5_room_categories')
                            ->get();

        $manage_booking=view('admin.hotel_management.booking.editbooking')
                         ->with('booking',$booking)
                         ->with('room_info',$room_info)
                         ->with('room_category',$room_category);
        return view('admin.master')
                         ->with('admin.hotel_management.booking.editbooking',$manage_booking);
    }
    //UPDATE ROOM-BOOKING
    public function update_booking(Request $request, $id)
    {
        $this->validate($request, [
          'guest_name'  => 'required|regex:/^[a-zA-Z ]*$/', 'string', 'max:100','unique:h8_room_bookings,guest_name'.$id,
          'guest_contact'  => ['required'],
          'start_date'  => ['required','date'],
          // 'end_date' => ['date'],
          'room_id' => ['required', 'integer'],
          'status'  => ['required', 'max:5']
        ]);

        $input = $request->all();

        $old_booking = RoomBooking::find( $id );
        $this->updateAISBooking( $old_booking, $input['amount']);
        $old_booking->update( $input);

        Session::put('message','Room Booking has been updated Successfully');
        return Redirect::to('/hotel_management/booking/booking_list');
    }
    //DELETE ROOM-BOOKING FROM DATABASE
    public function delete_booking($id)
    {
        DB::table('h8_room_bookings')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Room Booking has been deleted Successfully');
        return Redirect::to('/hotel_management/booking/booking_list');
    }
    //MAKE ROOM-BOOKING
    public function make_booking($id){
        $reservation_info=DB::table('h7_room_reservations')
                           ->where('id',$id)
                           ->first();
        $room_info=DB::table('h6_rooms')
                            ->get();

        $room_category = DB::table('h5_room_categories')
                            ->get();
        $manage_make_booking=view('admin.hotel_management.booking.makebooking')
                            ->with('reservation_info',$reservation_info)
                            ->with('room_info',$room_info)
                            ->with('room_category',$room_category);
        return view('admin.master')
                         ->with('admin.hotel_management.booking.makebooking',$manage_make_booking);
    }
    //SAVE MAKE-BOOKING TO DATABASE
    public function save_make_booking(Request $request)
    {
        $this->validate($request, [
          'guest_name'  => ['required', 'string', 'max:100','unique:h8_room_bookings'],
          'contact_no'  => ['required'],
          'start_date'  => ['required','date'],
           'end_date' => ['min:{{ start_date }}'],
          'room_id' => ['required', 'integer'],
          'status'  => ['required', 'max:5']
        ]);
        $date = $request->date;
        $input = $request->all();
        $voucher = $this->computeAIS($input, $date);
        $input['mis_voucher_id'] = $voucher->id;
        RoomBooking::create( $input);
        
        Session::put('message','Room Booking is Added Successfully');
        return Redirect::to('/hotel_management/booking/booking_list');
    }


    //------- METHODS FOR ROOM-BILLING --------//
    //ROOM-BILLING
    public function room_billing(){
        $room_billing=DB::table('h9_room_billings')
                            ->orderBy('id','desc')
                            ->get();
        $booking_info=DB::table('h8_room_bookings')
                            ->orderBy('id', 'desc')
                            ->get();
        $room_info=DB::table('h6_rooms')
                            ->get();
        $manage_room_billing=view('admin.hotel_management.billing.billing_list')
                            ->with('room_billing',$room_billing)
                            ->with('booking_info',$booking_info)
                            ->with('room_info',$room_info);
        return view('admin.master')
                         ->with('admin.hotel_management.billing.billing_list',$manage_room_billing);
    }
    //ADD ROOM-BILLING
    public function make_billing($id){
        $book_info = DB::table('h8_room_bookings')
                            ->where('id',$id)
                            ->first();
        $room_info = DB::table('h6_rooms')
                            ->orderBy('id','desc')
                            ->get();

        $manage_billing = view('admin.hotel_management.billing.makebilling')
                            ->with('book_info',$book_info)
                            ->with('room_info',$room_info);

        return view('admin.master')
                        ->with('admin.hotel_management.billing.makebilling',$manage_billing);
    }
    //SAVE ROOM-BILLING TO DATABASE
    public function save_billing(Request $request)
    {
        $this->validate($request, [
          'booking_id' => ['required', 'integer'],
          'advance_pay'  => ['required', 'min:0'],
          'total_pay'  => ['required', 'min:0'],
          'total_day'  => ['required', 'integer', 'min:0']
        ]);

        $input = $request->all();
        $billing = RoomBilling::create( $input);
        $due_bl = $billing->total_pay - $billing->booking->amount;
        $this->billingAIS( $billing->booking->voucher, $due_bl);
        Session::put('message','Room Booking is Added Successfully');
        return Redirect::to('/hotel_management/billing/billing_list');
    }
    //VIEW ROOM-BILLING
    public function view_billing($id){
        $booking_info=DB::table('h8_room_bookings')
                            ->get();
        $billing=DB::table('h9_room_billings')
                            ->where('id',$id)
                            ->first();
        $room_info=DB::table('h6_rooms')
                            ->get();
        $manage_billing_view=view('admin.hotel_management.billing.viewbilling')
                            ->with('booking_info',$booking_info)
                            ->with('billing',$billing)
                            ->with('room_info',$room_info);
        return view('admin.master')
                         ->with('admin.hotel_management.billing.viewbilling',$manage_billing_view);
    }
    //DELETE ROOM-BILLING FROM DATABASE
    public function delete_billing($id)
    {
        DB::table('h9_room_billings')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Room Billing has been deleted Successfully');
        return Redirect::to('/hotel_management/billing/billing_list');
    }

    //  FOOD SALE

    public function food_sale()
    {
        $room_bookings = DB::table('h8_room_bookings')->get();
        $venue_bookings = DB::table('v3_venue_bookings')->get();

        $menus = DB::table('r8_menus')->get();
        $menu_types = DB::table('r7_menu_types')->get();
        $rooms = DB::table('h6_rooms')->get();
        $venues = DB::table('v1_venues')->get();
        $sales = DB::table('r9_sales')->get();

        return view('admin.restaurant.sale.sale', compact('room_bookings', 'venue_bookings', 'menus', 'rooms', 'venues', 'sales', 'menu_types'));
    }

    public function add_food_sale()
    {
        $room_guests = DB::table('h8_room_bookings')->get();
        $venue_guests = DB::table('v3_venue_bookings')->get();
        $menus = DB::table('r8_menus')->get();
        $menu_types = DB::table('r7_menu_types')->get();

        return view('admin.restaurant.sale.add_sale', compact('room_guests', 'venue_guests', 'menus', 'menu_types'));
    }

    public function store_food_sale(Request $request)
    {
        $this->validate($request, [
            'guest_id' => 'required',
            'menu_id' => 'required',
            'menu_type' => 'required',
            'quantity' => 'required'
        ]);

        $date = Configuration::find(1)->software_start_date;

        $menu = DB::table('r8_menus')->where('id', $request->menu_id)->first();
        $input = $request->all();
        $input['amount'] = $request->quantity * $menu->price;
        $input['mis_ac_head_id'] = 4;
        $input['type'] = 'restaurant_rv';

        $voucher = $this->computeAIS( $input, $date);
        $input['mis_voucher_id'] = $voucher->id;
        Sale::create( $input);

        Session::put('message','Food Sales Created Successfully');
        return Redirect::to('/restaurant/sale/add-food-sale');
    }

    public function edit_food_sale($id)
    {
        $room_guests = DB::table('h8_room_bookings')->get();
        $venue_guests = DB::table('v3_venue_bookings')->get();
        $menus = DB::table('r8_menus')->get();
        $sales = DB::table('r9_sales')->find($id);
        $menu_types = DB::table('r7_menu_types')->get();

        return view('admin.restaurant.sale.edit_sale', compact('room_guests', 'venue_guests', 'menus', 'sales', 'menu_types'));
    }

    public function update_food_sale(Request $request, $id)
    {
        $this->validate($request, [
            'guest_id' => 'required',
            'menu_id' => 'required',
            'menu_type' => 'required',
            'quantity' => 'required'
        ]);

        $input = $request->all();
        $old_record = Sale::find( $id );
        $menu = DB::table('r8_menus')->where('id', $request->menu_id)->first();
        $input['amount'] = $request->quantity * $menu->price;
        $this->updateAISBooking( $old_record, $input['amount']);
        $old_record->update( $input);

        Session::put('message','Food Sales Updated Successfully');
        return Redirect::to('/restaurant/sale/food-sale');
    }

    public function delete_food_sale($id)
    {
        DB::table('r9_sales')
            ->where('id',$id)
            ->delete();
        Session::put('message', 'Food Sales has been deleted Successfully');
        return Redirect::to('/restaurant/sale/food-sale');
    }
}
