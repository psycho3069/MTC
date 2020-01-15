<?php

namespace App\Http\Controllers;

use App\Checkout;
use Illuminate\Http\Request;
use DB;
use Session;
use PDF;

class CheckoutController extends Controller
{
    public function guestList()
    {
        $hotel_booking = DB::table('h8_room_bookings')->get();
        $venue_booking = DB::table('v3_venue_bookings')->get();
        $checkout_list = Checkout::get();
        return view('admin.guest_list.entry_register', compact('hotel_booking', 'venue_booking', 'checkout_list'));
    }
    public function checkoutRoom($id)
    {
        $checkout_hotel = DB::table('h8_room_bookings')->find($id);
        $hotel_bill = DB::table('h9_room_billings')->get();
        $venue_bill = DB::table('v4_venue_billings')->get();
        $restaurant_bill = DB::table('r9_sales')->get();
        $menus = DB::table('r8_menus')->get();
        $menuTypes = DB::table('r7_menu_types')->get();
        $rooms = DB::table('h6_rooms')->get();
        $venues = DB::table('v1_venues')->get();

        $venue_bookings = DB::table('v3_venue_bookings')->get();
        $venue_billings = DB::table('v4_venue_billings')->get();
        return view('admin.guest_list.room_checkout', compact('checkout_hotel', 'menuTypes', 'hotel_bill', 'venue_bill', 'restaurant_bill', 'menus', 'rooms', 'venues', 'venue_bookings', 'venue_billings'));
    }

    public function checkoutVenue($id)
    {
        $checkout_venue = DB::table('v3_venue_bookings')->find($id);
        $hotel_bill = DB::table('h9_room_billings')->get();
        $venue_bill = DB::table('v4_venue_billings')->get();
        $restaurant_bill = DB::table('r9_sales')->get();
        $menus = DB::table('r8_menus')->get();
        $menuTypes = DB::table('r7_menu_types')->get();
        $rooms = DB::table('h6_rooms')->get();
        $venues = DB::table('v1_venues')->get();

        $room_bookings = DB::table('h8_room_bookings')->get();
        $venue_billings = DB::table('v4_venue_billings')->get();

        return view('admin.guest_list.venue_checkout', compact('checkout_venue', 'hotel_bill', 'venue_bill', 'restaurant_bill', 'menus', 'menuTypes', 'room_bookings', 'venue_billings', 'rooms', 'venues'));
    }

    public function checkoutList()
    {
        $checkoutList = Checkout::get();
        return view('admin.guest_list.checkout_list', compact('checkoutList'));
    }

    public function billDetails($id)
    {
        $viewBill = Checkout::find($id);
        return view('admin.guest_list.bill', compact('viewBill'));
    }

    public function viewBill()
    {
        $viewBill = Checkout::latest()->first();
        return view('admin.guest_list.bill', compact('viewBill'));
    }

    public function storeChceckout(Request $request)
    {
        $insert = $request->all();

        Checkout::create( $insert);

        Session::put('message','Checkout Successfully');
        return redirect()->route('checkout');
    }

    public function generatePDF($id)
    {
        $viewBill = Checkout::find($id);
//        return $viewBill;
        $data = ['title' => 'MTC'];
        view()->share('viewBill',$viewBill);
        view()->share('data',$data);

        $pdf = PDF::loadView('admin.guest_list.billPDF');

        return $pdf->download('bill.pdf'); //stream
    }

    public function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('v3_venue_bookings')
                    ->where('contact_no', 'like', '%'.$query.'%')
                    ->get();

            }
            else
            {
                $data = '
                   <span></span>
                   ';
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                     <option value="'.$row->id.'">'.$row->name.'</option>
                    ';
                }
            }
            else
            {
                $output = '
                   <span></span>
                   ';
            }
            $data = array(
                'select_data'  => $output
            );

            echo json_encode($data);
        }
    }

    public function actionVenue(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('h8_room_bookings')
                    ->where('guest_contact', 'like', '%'.$query.'%')
                    ->get();

            }
            else
            {
                $data = '
                   <span></span>
                   ';
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                     <option value="'.$row->id.'">'.$row->guest_name.'</option>
                    ';
                }
            }
            else
            {
                $output = '
                   <span></span>
                   ';
            }
            $data = array(
                'select_data'  => $output
            );

            echo json_encode($data);
        }
    }
}
