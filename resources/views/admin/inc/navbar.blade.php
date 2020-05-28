{{-- navbar --}}

<nav class="navbar navbar-expand-sm navbar-dark" style="padding-right: 80px;">

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
          </div>
      </li>

      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Configuration
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{ route('configure.hotel') }}">Hotel</a>
              <a class="dropdown-item" href="{{ route('units.index') }}">Unit</a>
              <a class="dropdown-item" href="{{ route('configure.ledger', 1) }}">Grocery</a>
              <a class="dropdown-item" href="{{ route('configure.ledger', 2) }}">Inventory</a>
          </div>
      </li>

      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Management
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{URL::to('/hotel_management/building/building_type_list')}}">Building Types</a>
              <a class="dropdown-item" href="{{URL::to('/hotel_management/building/building_list')}}">Buildings</a>
              <a class="dropdown-item" href="{{URL::to('/hotel_management/floor/floor_type_list')}}">Floor Types</a>
              <a class="dropdown-item" href="{{URL::to('/hotel_management/floor/floor_list')}}">Floors</a>
              <a class="dropdown-item" href="{{URL::to('/hotel_management/room/room_category_list')}}">Room Category</a>
              <a class="dropdown-item" href="{{URL::to('/hotel_management/room/room_list')}}">Rooms</a>
              <a class="dropdown-item" href="{{URL::to('/training/venue')}}">Venue</a>
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
              <a class="dropdown-item" href="{{ route('supplier.index') }}">Supplier</a>
              <a class="dropdown-item" href="{{URL::to('/hr_payroll/leave/leave_categories')}}">Leave Category</a>
              <a class="dropdown-item" href="{{URL::to('/hr_payroll/leave/leaves')}}">Leave</a>
          </div>
      </li>

    <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Hotel
      </a>
      <div class="dropdown-menu sm-menu">
          <a class="dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer')}}">Rooms</a>
          <a class="dropdown-item" href="{{ route('billing.index',['res' => 1]) }}">Reservation</a>
          <a class="dropdown-item" href="{{ route('billing.index') }}">Bill</a>
          <a class="dropdown-item" href="{{ route('billing.index', ['chk' => 1]) }}">Checkout</a>
          <a class="dropdown-item" href="{{ route('discount.index') }}">Discount</a>
      </div>
    </li>



      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Restaurant
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{ route('sales.index') }}">Sales</a>
              <a class="dropdown-item" href="{{ route('sales.create') }}">Sale Food</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/meal_item_type/meal_item_types')}}">Meal Types</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/meal_item/meal_items')}}">Meals</a>
              <a class="dropdown-item" href="{{URL::to('/restaurant/menu_type/menu_types')}}">Menu Types</a>
              <a class="dropdown-item" href="{{ route('menu.index') }}">Menus</a>
          </div>
      </li>


      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Grocery
          </a>
          <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="{{ route('stock.index', ['mis_head_id' => 4]) }}">Groceries</a>
              <a class="dropdown-item" href="{{ route('stock.list', ['mis_head_id' => 4]) }}">Stock</a>
              <a class="dropdown-item" href="{{ route('purchase.index', ['mis_head_id' => 4]) }}">Purchase</a>
              <a class="dropdown-item" href="{{ route('deliver.index') }}">Delivery</a>
              <a class="dropdown-item" href="{{ route('stock.opening', ['mis_head_id' => 4]) }}">Opening Balance</a>
          </div>
      </li>



      <li class="nav-item dropdown dmenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Inventory
          </a>
          <div class="dropdown-menu sm-menu">
              {{-- type_id = 1 for Inventory, cat_id = 1 Suppliers--}}
              <a class="dropdown-item" href="{{ route('stock.index', ['mis_head_id' => 5]) }}">Inventories</a>
              <a class="dropdown-item" href="{{ route('stock.list', ['mis_head_id' => 5]) }}">Stock</a>
              <a class="dropdown-item" href="{{ route('purchase.index', ['mis_head_id' => 5]) }}">Purchase</a>
              <a class="dropdown-item" href="{{ route('stock.opening', ['mis_head_id' => 5]) }}">Opening Balance</a>
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
              <a href="{{ route('process.list') }}" class="dropdown-item">Day End</a>
              <a href="{{ route('process.index') }}" class="dropdown-item">Day End List</a>
          </div>
      </li>
    <li class="nav-item dropdown dmenu">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Reports
      </a>
      <div class="dropdown-menu sm-menu">
          <a class="dropdown-item" href="{{ route('report.ledger') }}">Ledger Report</a>
          <a class="dropdown-item" href="{{ route('report.daily') }}">Daily Transaction Report</a>
          <a class="dropdown-item" href="{{ route('report.cash-book') }}">Cash Book Report</a>
          <a class="dropdown-item" href="{{ route('report.bank-book') }}">Bank Book Report</a>
          <a class="dropdown-item" href="{{ route('report.receipt_payment') }}">Receipt Payment Report</a>
          <a class="dropdown-item" href="{{ route('report.cash-bank-book') }}">Cash & Bank Book Report</a>
          <a class="dropdown-item" href="{{ route('report.balance') }}">Balance Sheet</a>
          <a class="dropdown-item" href="{{ route('report.income') }}">Income Statement</a>
          <a class="dropdown-item" href="{{ route('report.stock', 4) }}">Grocery Report</a>
          <a class="dropdown-item" href="{{ route('report.stock', 5) }}">Inventory Report</a>
      </div>
    </li>
  </ul>

</div>

</nav>
