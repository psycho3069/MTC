{{-- navbar --}}

<nav class="navbar navbar-expand-sm navbar-dark" style="padding-right: 80px; box-shadow: inset 2px -4px 11px #92482b;">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar4">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbar4">

  <ul class="navbar-nav nav-fill w-100">
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/home') }}">Dashboard</a>
    </li>
      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Admin
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{URL::to('/admin/user/user')}}">User</a>
              <a class="dropdown-item" href="{{URL::to('/admin/user_role/userrole')}}">User Role</a>
              <a class="dropdown-item" href="{{URL::to('/admin/role_wise_permission/role_wise_permission')}}">Role Wise Permission</a>
          <!-- <a class="dropdown-item" href="{{URL::to('/maintenance')}}">Role Wise Permission</a> -->
          <!-- <a class="dropdown-item" href="{{URL::to('/admin/change_password/changepassword')}}">Change Password</a> -->
              <a class="dropdown-item" href="{{URL::to('/maintenance')}}">Change Password</a>
              {{-- <a class="dropdown-item" href="{{URL::to('/guest-list')}}">Guest List</a> --}}
              {{-- <a class="dropdown-item" href="{{ route('checkoutList') }}">Entery Register List</a> --}}
          </div>
      </li>

      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Configuration
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{ route('mis.accounts.index') }}">Configuration</a>
              <a class="dropdown-item" href="{{URL::to('/maintenance')}}">Discount</a>
          </div>
      </li>
    <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Hotel Management
      </a>
      <div class="dropdown-menu sm-menu">
        <a class="dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer')}}">Rooms Viewer</a>
          <a class="dropdown-item" href="{{URL::to('/hotel_management/reservation/room_reservation_list')}}">Reservation</a>
{{--          <a class="dropdown-item" href="{{URL::to('/hotel_management/booking/booking_list')}}">Booking</a>--}}
{{--          <a class="dropdown-item" href="{{URL::to('/hotel_management/billing/billing_list')}}">Billing</a>--}}
          <a class="dropdown-item" href="{{URL::to('/hotel_management/building/building_type_list')}}">Building Types</a>
          <a class="dropdown-item" href="{{URL::to('/hotel_management/building/building_list')}}">Buildings</a>
          <a class="dropdown-item" href="{{URL::to('/hotel_management/floor/floor_type_list')}}">Floor Types</a>
          <a class="dropdown-item" href="{{URL::to('/hotel_management/floor/floor_list')}}">Floors</a>
          <a class="dropdown-item" href="{{URL::to('/hotel_management/room/room_category_list')}}">Room Category</a>
        <a class="dropdown-item" href="{{URL::to('/hotel_management/room/room_list')}}">Rooms</a>
      </div>
    </li>


      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Billing
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{ route('billing.index') }}">Billing</a>
              <a class="dropdown-item" href="{{ route('sales.create') }}">Restaurant</a>
          </div>
      </li>

    <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        HR & Payroll
      </a>
      <div class="dropdown-menu sm-menu">
          <a class="dropdown-item" href="{{URL::to('/hr_payroll/department/departments')}}">Department</a>
          <a class="dropdown-item" href="{{URL::to('/hr_payroll/employee_designation/employee_designations')}}">Employee Designation</a>
          <a class="dropdown-item" href="{{URL::to('/hr_payroll/salary_grade/salary_grades')}}">Salary Grade</a>
          <a class="dropdown-item" href="{{URL::to('/hr_payroll/employee/employees')}}">Employee</a>
          <a class="dropdown-item" href="{{URL::to('/hr_payroll/leave/leave_categories')}}">Leave Category</a>
          <a class="dropdown-item" href="{{URL::to('/hr_payroll/leave/leaves')}}">Leave</a>
      </div>
    </li>
      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Restaurant
          </a>
          <div class="dropdown-menu sm-menu">
              {{-- type_id = 2 for Restaurant, cat_id = 1 Suppliers--}}
              <a class="dropdown-item" href="{{ route('staff.index', ['type_id' => 3, 'cat_id' => 1]) }}">Supplier</a>
              <a class="dropdown-item" href="{{ route('stock.index', ['type_id' => 3]) }}">Grocery Category</a>
              <a class="dropdown-item" href="{{ route('stock.list', ['type_id' => 3]) }}">Grocery List</a>
              <a class="dropdown-item" href="{{ route('purchase.create', ['type_id' => 3]) }}">Purchase</a>
              <a class="dropdown-item" href="{{ route('sales.create') }}">Sales</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/meal_item/meal_items')}}">Meal Items</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/meal_item_type/meal_item_types')}}">Meal Types</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/menu/menus')}}">Menus</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/menu_type/menu_types')}}">Menu Types</a>
              <a class="dropdown-item" href="{{ route('purchase.index', ['type_id' => 3]) }}">Grocery Balance</a>
              <a class="dropdown-item" href="{{ route('stock.opening', ['type_id' => 3]) }}">Opening Balance</a>
          </div>
      </li>
    <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Training Centre
      </a>
      <div class="dropdown-menu sm-menu">
        <a class="dropdown-item" href="{{URL::to('/training/venue')}}">Venue</a>
        <a class="dropdown-item" href="{{URL::to('/training/venueRes')}}">Venue Reservation</a>
{{--        <a class="dropdown-item" href="{{URL::to('/training/venue-booking-list')}}">Venue Booking</a>--}}
{{--        <a class="dropdown-item" href="{{URL::to('/training/venue-billing-list/')}}">Venue Billing</a>--}}
      </div>
    </li>

      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Inventory
          </a>
          <div class="dropdown-menu sm-menu">
              {{-- type_id = 1 for Inventory, cat_id = 1 Suppliers--}}
              <a class="dropdown-item" href="{{ route('staff.index', ['type_id' => 5, 'cat_id' => 1]) }}">Supplier</a>
              <a class="dropdown-item" href="{{ route('stock.list', ['type_id' => 5]) }}">Inv List</a>
              <a class="dropdown-item" href="{{ route('stock.index', ['type_id' => 5]) }}">Category List</a>
              <a class="dropdown-item" href="{{ route('purchase.create', ['type_id' => 5]) }}">Purchase</a>
              <a class="dropdown-item" href="{{ route('purchase.index', ['type_id' => 5]) }}">Inventory Balance</a>
              <a class="dropdown-item" href="{{ route('stock.opening', ['type_id' => 5]) }}">Opening Balance</a>
          </div>
      </li>


      <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Accounting
      </a>
      <div class="dropdown-menu sm-menu">
          <a href="{{ route('accounts.index') }}" class="dropdown-item">Account list</a>
          <a href="{{ route('balance.index') }}" class="dropdown-item">Opening balance</a>
      </div>
    </li>
    <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Voucher</a>
          <div class="dropdown-menu sm-menu">
              <a href="{{ route('vouchers.index') }}" class="dropdown-item">Vouchers List</a>
              <a href="{{ route('vouchers.create',[ 'type_id' => 1]) }}" class="dropdown-item">Payment Voucher (manual)</a>
              <a href="{{ route('vouchers.create',[ 'type_id' => 2]) }}" class="dropdown-item">Receipt voucher (manual)</a>
              <a href="{{ route('vouchers.create',[ 'type_id' => 3]) }}" class="dropdown-item">Journal vouchers (manual)</a>
              <a href="{{ route('vouchers.create',[ 'type_id' => 4]) }}" class="dropdown-item">Contra vouchers (manual)</a>
          </div>
        </li>
      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Process
          </a>
          <div class="dropdown-menu sm-menu">
              <a href="{{ route('process.list') }}" class="dropdown-item">AIS Day End</a>
              <a href="{{ route('process.index') }}" class="dropdown-item">AIS Day End List</a>
          </div>
      </li>
    <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Reports
      </a>
      <div class="dropdown-menu sm-menu">
{{--        <a class="dropdown-item" href="">Inventory Report</a>--}}
        <a class="dropdown-item" href="{{ route('report.ledger') }}">Ledger Report</a>
{{--        <a class="dropdown-item" href="">Chart of Account Report</a>--}}
        <a class="dropdown-item" href="{{ route('report.daily') }}">Daily Transaction Report</a>
        <a class="dropdown-item" href="{{ route('report.ledger', 353) }}">Cash Book Report</a>
{{--        <a class="dropdown-item" href="">Bank Book Report</a>--}}
{{--        <a class="dropdown-item" href="{{ route('report.cash') }}">Cash Flow Report</a>--}}
        <a class="dropdown-item" href="{{ route('report.balance') }}">Balance Sheet</a>
        <a class="dropdown-item" href="{{ route('report.income') }}">Income Statement</a>
      </div>
    </li>
    {{-- <li class="nav-item dropdown dmenu">
      <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </li> --}}

    {{-- <li class="nav-item">
      <a class="nav-link" href="https://lawmessengerbd.com:2096" target="_blank">Web Mail</a>
    </li> --}}
  </ul>

</div>

</nav>
