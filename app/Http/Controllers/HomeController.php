<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\MisAccountHead;
use App\Process;
use App\VenueBilling;
use App\VenueBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\CustomTrait;
use DB;
use Auth;
use PDF;
use Session;
use Exception;
use function GuzzleHttp\Promise\all;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');

        $room = DB::table('h6_rooms')->count();
        $room_bookings = DB::table('h8_room_bookings')->count();
        $venue = DB::table('v1_venues')->count();
        $venue_bookings = DB::table('v3_venue_bookings')->count();

        $employees=DB::table('e4_employees')
            ->join('e1_departments', 'e4_employees.department_id', '=', 'e1_departments.id')
            ->select('e4_employees.*', 'e1_departments.id as depId')
            ->orderBy('e4_employees.id', 'desc')
            ->count();

        $employees_total=DB::table('e4_employees')
            ->count();

        $leaves=DB::table('e6_leaves')
            ->count();

        $departments = DB::table('e1_departments')->get();

        $stock_heads = DB::table('stock_heads')->get();
        $stocks = DB::table('stocks')->get();

        return view('admin.home.homeContent', compact('room','room_bookings','venue','venue_bookings','employees','departments','stock_heads','stocks','leaves','employees_total'));
    }

    // --- METHODS FOR VENUE --- //
    //VENUE
    public function venue(){
        $allvenueinfo=DB::table('v1_venues')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_venue=view('admin.training.venue')
                         ->with('allvenueinfo',$allvenueinfo);
        return view('admin.master')
                         ->with('admin.training.venue',$manage_venue);
    }
    //ADD VENUE
    public function addvenue(){
        return view('admin.training.addvenue');
    }
    //ADD VENUE IN DATABASE
    public function savevenue(Request $request)
    {
        $this->validate($request, [
          'name'  => 'required|max:120',
          'location'  => 'required|max:120',
          'price'  => 'required|max:30',
          'feature'  => 'required|max:255'
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['location'] = $request->location;
        $data['price'] = $request->price;
        $data['feature'] = $request->feature;

        DB::table('v1_venues')->insert($data);
        Session::put('message','Venue is Added Successfully');
        return Redirect::to('/training/addvenue');
    }
    //DELETE VENUE IN DATABASE
    public function delete_venue($id)
    {
      try {
        DB::table('v1_venues')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Venue is deleted Successfully');
        return Redirect::to('/training/venue');
        } catch (Exception $e) {
            //return back()->withError($e->getMessage());
            return back()->withError('This venue cannot be deleted because it is reserved or allocated or cancelled. To delete this venue, delete reservation first, then delete it.');
        }
    }
    //EDIT VENUE IN DATABASE
    public function edit_venue($id)
    {
        $venueinfo=DB::table('v1_venues')
                           ->where('id',$id)
                           ->first();

        $manage_venue=view('admin.training.editvenue')
                         ->with('allvenueinfo',$venueinfo);
        return view('admin.master')
                         ->with('admin.training.editvenue',$manage_venue);
    }
    //UPDATE VENUE IN DATABASE
    public function update_venue(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['location'] = $request->location;
        $data['price'] = $request->price;
        $data['feature'] = $request->feature;

        DB::table('v1_venues')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Venue is updated Successfully');
        return Redirect::to('/training/venue');
    }
    //VENUE RESERVATION
    public function venueRes(){
        $allvenueresinfo=DB::table('v2_venue_reservations')
                         ->join('v1_venues', 'v2_venue_reservations.venue_id', '=', 'v1_venues.id')
                         ->select('v2_venue_reservations.*', 'v1_venues.name as venueName', 'v1_venues.price as vprice')
                         ->orderBy('v2_venue_reservations.id', 'desc')
                         ->get();
//        return $allvenueresinfo;
        $manage_venueres=view('admin.training.venueRes')
                         ->with('allvenueresinfo',$allvenueresinfo);
        return view('admin.master')
                         ->with('admin.training.venueRes',$manage_venueres);
    }

    // //VENUE RESERVATION
    // public function venueRes(){
    //     $allvenueresinfo=DB::table('v2_venue_reservations')
    //                      ->join('v1_venues', 'v2_venue_reservations.venue_id', '=', 'v1_venues.id')
    //                      ->select('v2_venue_reservations.*', 'v1_venues.name as venueName', 'v1_venues.price as vprice')
    //                      ->orderBy('v2_venue_reservations.id', 'desc')
    //                      ->get();
    //     $manage_venueres=view('admin.training.venueRes')
    //                      ->with('allvenueresinfo',$allvenueresinfo);
    //     return view('admin.master')
    //                      ->with('admin.training.venueRes',$manage_venueres);
    // }

    //FETCH VENUE PRICE
    function fetch(Request $request)
        {
         $select = $request->get('select');
         $value = $request->get('value');
         $dependent = $request->get('dependent');
         $data = DB::table('v1_venues')
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

    //DELETE VENUE RESERVATION IN DATABASE
    public function delete_venueres($id)
    {
        DB::table('v2_venue_reservations')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Venue Reservation is deleted Successfully');
        return Redirect::to('/training/venueRes');
    }
    //EDIT VENUE RESERVATION IN DATABASE
    public function edit_venueres($id)
    {
        $allvenueinfo=DB::table('v1_venues')
                           ->orderBy('id', 'desc')
                           ->get();
        $venueresinfo=DB::table('v2_venue_reservations')
                           ->where('id',$id)
                           ->first();

        $manage_venueres=view('admin.training.editvenueRes')
                         ->with('allvenueresinfo',$venueresinfo)
                         ->with('allvenueinfo',$allvenueinfo);
        return view('admin.master')
                         ->with('admin.training.editvenueRes',$manage_venueres);
    }
    //UPDATE VENUE RESERVATION IN DATABASE
    public function update_venueres(Request $request, $id)
    {
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

        DB::table('v2_venue_reservations')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Venue Reservation is updated Successfully');
        return Redirect::to('/training/venueRes');
    }
    public function view_venueres($id){
        $allvenueresinfo=DB::table('v2_venue_reservations')
                         ->join('v1_venues', 'v2_venue_reservations.venue_id', '=', 'v1_venues.id')
                         ->select('v2_venue_reservations.*', 'v1_venues.name as venueName', 'v1_venues.price as vprice')
                         ->where('v2_venue_reservations.id',$id)
                        ->first();
        $manage_venueres=view('admin.training.viewvenueRes')
                         ->with('allvenueresinfo',$allvenueresinfo);
        return view('admin.master')
                         ->with('admin.training.viewvenueRes',$manage_venueres);
    }
    public function pdf($id){

     $data['title'] = 'Notes List';
     //$data['notes'] =  Note::get();
     $data['notes'] =  DB::table('v2_venue_reservations')
                         ->join('v1_venues', 'v2_venue_reservations.venue_id', '=', 'v1_venues.id')
                         ->select('v2_venue_reservations.*', 'v1_venues.name as venueName', 'v1_venues.price as vprice')
                         ->where('v2_venue_reservations.id',$id)
                        ->get();

     //$pdf = PDF::loadView('notes.list_notes', $data);
     $pdf = PDF::loadView('admin.training.venueReservPdf', $data);
     //$pdf = view('admin.training.venueReservPdf', $data);

     return $pdf->download('venue_reservation_details.pdf');
    }
    public function venueAlloc(){
        return view('admin.training.venueAlloc');
    }

    public function venueBookingList()
    {
        $bookings = DB::table('v3_venue_bookings')
                    ->join('v1_venues', 'v3_venue_bookings.venue_id', '=', 'v1_venues.id')
                    ->select('v3_venue_bookings.*', 'v1_venues.name as venueName')
                    ->orderBy('v3_venue_bookings.id', 'desc')
                    ->get();
//        return $bookings;
        return view('admin.training.venueBookingList', compact('bookings'));
    }

    public function edit_venueBook($id)
    {
        $bookings = DB::table('v3_venue_bookings')->find($id);
        $allvenueinfo = DB::table('v1_venues')->get();
        return view('admin.training.editvenueBook', compact('bookings', 'allvenueinfo'));
    }

    public function updateVenueBook(Request $request, $id)
    {
        $this->validate($request, [
            'name'  => 'required|max:60|regex:/^[a-zA-Z ]*$/',
            'contact_no'  => 'required|max:30',
            'start_date'  => 'required|date',
            'end_date'  => 'nullable|date',
            'venue_id'  => 'required|max:10',
            'amount'  => 'required|max:30',
            'no_of_attendee'  => 'required|max:10',
            'status'  => 'required|max:5'
        ]);

        $input = $request->all();
        $old_booking = VenueBooking::find( $id );
        $this->updateAISBooking( $old_booking, $input['amount']);
        $old_booking->update( $input);

        Session::put('message','Venue booking is updated Successfully');
        return Redirect::to('/training/venue-booking-list');
    }

    public function delete_venueBooking($id)
    {
        DB::table('v3_venue_bookings')
            ->where('id',$id)
            ->delete();
        Session::put('message', 'Venue booking is deleted Successfully');
        return Redirect::to('/training/venue-booking-list');
    }

    public function make_venueBook($id)
    {
        $reservationInfo = DB::table('v2_venue_reservations')->find($id);
        $allvenueinfo = DB::table('v1_venues')->get();
        return view('admin.training.makevenueBook', compact('reservationInfo', 'allvenueinfo'));
    }

    public function venuebillingList()
    {
        $venue_billings = DB::table('v4_venue_billings')->get();
        $booking_info = DB::table('v3_venue_bookings')->get();
        $allvenueinfo = DB::table('v1_venues')->get();

        return view('admin.training.billing_list', compact('venue_billings','booking_info','allvenueinfo'));
    }

    public function makebilling($id)
    {
        $billing = DB::table('v3_venue_bookings')->find($id);
        $allvenueinfo = DB::table('v1_venues')->get();
        return view('admin.training.makebilling', compact('billing', 'allvenueinfo'));
    }

    public function storeBilling(Request $request)
    {
        $this->validate($request, [
            'venue_booking_id'  => 'required',
            'advanced_pay'  => 'required',
            'total_pay'  => 'required',
            'total_day'  => 'required',
        ]);

        $input = $request->all();
        $billing = VenueBilling::create( $input);
        $due_bl = $billing->total_pay - $billing->booking->amount;
        $this->billingAIS( $billing->booking->voucher, $due_bl);

        Session::put('message','Venue billing Successfully');
        return Redirect::to('training/venue-billing-list');
    }

    public function delete_venueBilling($id)
    {
        DB::table('v4_venue_billings')
            ->where('id',$id)
            ->delete();
        Session::put('message', 'Venue billings is deleted Successfully');
        return Redirect::to('/training/venue-billing-list');
    }

}
