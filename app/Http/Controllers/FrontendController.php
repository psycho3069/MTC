<?php

namespace App\Http\Controllers;

use App\Booking;
use App\VenueBooking;
use Illuminate\Http\Request;
use App\RoomBooking;

use DB;
use Session;
use App\Http\Traits\CustomTrait;
use App\Configuration;

class FrontendController extends Controller
{
    use CustomTrait;

    public function home()
    {
        $room_categories = DB::table('h5_room_categories')->get();

        return view('mtchome', compact('room_categories'));
    }

    public function room_viewer(){
        $venues=DB::table('v1_venues')->get();
        $venuereservations=DB::table('v2_venue_reservations')->get();
        $venuebookings=DB::table('v3_venue_bookings')->get();

        $booking = Booking::where('end_date','>=', date('Y-m-d'))->get();

        return view('admin.hotel_management.room.room_viewer', compact('venues','venuereservations','venuebookings', 'booking'));
    }



    //------- METHODS FOR ROOM --------//

    // FLOOR 1
    public function floor1()
    {
        $reservation = DB::table('h7_room_reservations')->get();
        $venuereservation = DB::table('v2_venue_reservations')->get();
        $booked = DB::table('h8_room_bookings')->get();
        $venuebooking = DB::table('v3_venue_bookings')->get();
        $rooms = DB::table('h6_rooms')->get();
        $room_category = DB::table('h5_room_categories')->get();
        $venues = DB::table('v1_venues')->get();

        $booking = Booking::where('end_date','>=', date('Y-m-d'))->get();
        return view('admin.hotel_management.room.floor1', compact('reservation', 'booking', 'rooms', 'room_category', 'venues', 'venuereservation', 'venuebooking', 'booked'));
    }

    public function viewFloor1($id)
    {
        $view = DB::table('h6_rooms')->find($id);
        return compact('view');
    }

    // FLOOR 2
    public function floor2()
    {
        $reservation = DB::table('h7_room_reservations')->get();
        $booking = DB::table('h8_room_bookings')->get();
        $rooms = DB::table('h6_rooms')->get();
        $room_category = DB::table('h5_room_categories')->get();
        return view('admin.hotel_management.room.floor2', compact('reservation', 'booking', 'rooms', 'room_category'));
    }

    // FLOOR 3
    public function floor3()
    {
        $reservation = DB::table('h7_room_reservations')->get();
        $booking = DB::table('h8_room_bookings')->get();
        $rooms = DB::table('h6_rooms')->get();
        $room_category = DB::table('h5_room_categories')->get();
        return view('admin.hotel_management.room.floor3', compact('reservation', 'booking', 'rooms', 'room_category'));
    }

    // FLOOR 4
    public function floor4()
    {
        $reservation = DB::table('h7_room_reservations')->get();
        $venuereservation = DB::table('v2_venue_reservations')->get();
        $venuebooking = DB::table('v3_venue_bookings')->get();
        $booking = DB::table('h8_room_bookings')->get();
        $rooms = DB::table('h6_rooms')->get();
        $room_category = DB::table('h5_room_categories')->get();
        $venues = DB::table('v1_venues')->get();
        return view('admin.hotel_management.room.floor4', compact('reservation', 'booking', 'rooms', 'room_category', 'venues', 'venuereservation', 'venuebooking'));
    }

    public function viewVenues($id)
    {
        $view = DB::table('v1_venues')->find($id);
        return compact('view');
    }


    //ADD ROOM-BOOKING
    public function add_booking($id){

        $room_info = DB::table('h6_rooms')->find($id);
        $room_category = DB::table('h5_room_categories')->get();
        $reserve = DB::table('h7_room_reservations')->get();
        $booked = DB::table('h8_room_bookings')->get();

        return view('admin.hotel_management.booking.addbooking', compact('room_category','room_info','reserve','booked'));

    }

    //SAVE ROOM-BOOKING TO DATABASE
    public function save_booking(Request $request)
    {
//        return $request->all();
        $this->validate($request, [
            'guest_name'  => ['required', 'string', 'max:100','regex:/^[a-zA-Z ]*$/','unique:h8_room_bookings'],
            'guest_contact'  => ['required'],
            'start_date'  => ['required','date'],
            'end_date' => ['nullable','date'],
            'room_id' => ['required', 'integer'],
            'status'  => ['required', 'max:5']
        ]);

        // $date = $request->date;
        $date = Configuration::find(1)->software_start_date;
        $input = $request->all();
        $input['type'] = 'hotel_rv';
        $input['mis_ac_head_id'] = 1;
        $voucher = $this->computeAIS($input, $date);
        $input['mis_voucher_id'] = $voucher->id;
        RoomBooking::create( $input);

        Session::put('message','Room Booking is Added Successfully');
        return redirect()->back();
    }

    //ADD ROOM-RESERVATION
    public function add_reservation($id){

        $room_info = DB::table('h6_rooms')->find($id);
        $room_category = DB::table('h5_room_categories')->get();
        $reserve = DB::table('h7_room_reservations')->get();
        $booked = DB::table('h8_room_bookings')->get();

        return view('admin.hotel_management.reservation.addreservation', compact('room_category','room_info','reserve','booked'));

    }

    //SAVE ROOM-RESERVATION TO DATABASE
    public function save_reservation(Request $request)
    {
        $this->validate($request, [
            'org_name'  => ['required','regex:/^[a-zA-Z ]*$/'],
            'guest_name'  => ['required', 'regex:/^[a-zA-Z ]*$/', 'string', 'max:100','unique:h7_room_reservations'],
            'contact_no'  => ['required'],
            'start_date'  => ['required','date'],
            'end_date' => ['min:{{ start_date }}'],
            'room_id' => ['required', 'integer'],
            'status'  => ['required', 'max:5']
        ]);
        $data = array();
        $data['org_name'] = $request->org_name;
        $data['designation'] = $request->designation;
        $data['guest_name'] = $request->guest_name;
        $data['guest_contact'] = $request->contact_no;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['room_id'] = $request->room_id;
        $data['status'] = $request->status;
        $data['created_at'] = now();

        DB::table('h7_room_reservations')->insert($data);
        Session::put('message','Room Reservation is Added Successfully');
        return redirect()->back();
    }


    public function add_venueBook($id)
    {
        $bookings = DB::table('v3_venue_bookings')->get();
        $allvenueinfo = DB::table('v1_venues')->find($id);
        $reserve = DB::table('v2_venue_reservations')->get();
        $booked = DB::table('v3_venue_bookings')->get();
        return view('admin.training.addvenueBook', compact('bookings', 'allvenueinfo', 'reserve', 'booked'));
    }

    public function storeVenueBook(Request $request)
    {
//        return $request->all();
        $this->validate($request, [
            'name'  => 'required|max:60|regex:/^[a-zA-Z ]*$/',
            'contact_no'  => 'required|max:30',
            'start_date'  => 'required|date',
            'end_date'  => 'nullable|date',
            'venue_id'  => 'required|max:10',
            'no_of_attendee'  => 'required|max:10',
            'status'  => 'required|max:5'
        ]);

        $date = Configuration::find(1)->software_start_date;

        $input = $request->all();
        $input['type'] = 'venue_rv';
        $voucher = $this->computeAIS( $input, $date);
        $input['mis_voucher_id'] = $voucher->id;
        VenueBooking::create( $input);

        Session::put('message','Venue is booked Successfully');
        return redirect()->back();
    }

    //ADD VENUE RESERVATION
    public function addvenueRes($id){
        $allvenueinfo=DB::table('v1_venues')->find($id);
        $reserve = DB::table('v2_venue_reservations')->get();
        $booked = DB::table('v3_venue_bookings')->get();

        $manage_venue=view('admin.training.addvenueRes')
            ->with('allvenueinfo',$allvenueinfo)
            ->with('reserve',$reserve)
            ->with('booked',$booked);
        return view('admin.master')
            ->with('admin.training.addvenueRes',$manage_venue);
    }

    //ADD VENUE RESERVATION IN DATABASE
    public function savevenueRes(Request $request)
    {
        $this->validate($request, [
            'org_name'  => 'required|regex:/^[a-zA-Z ]*$/',
            'name'  => 'required|max:60|regex:/^[a-zA-Z ]*$/',
            'contact_no'  => 'required|max:30',
            'start_date'  => 'required|date',
            'end_date'  => 'nullable|date',
            'venue_id'  => 'required|max:10',
            'price'  => 'required|max:30',
            'no_of_attendee'  => 'required|max:10',
            'status'  => 'required|max:5'
        ]);
        $data = array();
        $data['org_name'] = $request->org_name;
        $data['name'] = $request->name;
        $data['contact_no'] = $request->contact_no;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['venue_id'] = $request->venue_id;
        $data['price'] = $request->price;
        $data['no_of_attendee'] = $request->no_of_attendee;
        $data['status'] = $request->status;

        DB::table('v2_venue_reservations')->insert($data);
        Session::put('message','Venue is reserved Successfully');
        return redirect()->back();
    }
}
