{{-- header --}}
<div class="container-fluid" style="background-color: #1f9bcc; font-family: 'Nunito', sans-serif; font-weight: 200; ">
      <div class="row">
        {{-- <div class="col-md-12"> --}}
          <div class="col-md-2 col-xs-3" style="padding-top: 5px; padding-bottom: 3px; ">

          <p id="demo" style="color: white;"></p>

              <p style="color: whitesmoke;">Software date : <b style="color: whitesmoke;">{{ date('d-m-Y', strtotime(\App\Configuration::find(1)->software_start_date)) }}</b></p>


            <p style="color: #99c2ff; font-size: 25px; font-family: 'Times New Roman', Times, serif; ">
              &nbsp;&nbsp;
              <a href="{{ url('/') }}">
                  <img src="{{ asset('img/mtclogo.png')}}" height="75px" width="75px">
              </a>

              &nbsp;<!-- <b>{{ config('app.name', 'Laravel') }}</b> -->
            </p>

           </div>
           <div class="col-md-8 col-xs-6" style="padding-top: 15px;">
            <h4 style="text-align: center; color: white; ">ASPADA Paribesh Unnayan Foundation</h4>
            <h5 style="text-align: center; color: white; "><?php //echo $pr_name; ?>Microfinance for better Future</h5>
            <h6 style="text-align: center; color: white; "><?php //echo $org_address; ?>House:193(1st Floor), Road:1, New DOHS, Mohakhali, Dhaka-1206</h6>
           </div>
          <div class="col-md-2 col-xs-3" style="padding-right: 8px; text-align: right; padding-top: 2px; ">
            {{-- <a href="../include/logout.php" class="btn btn-primary"><span class="glyphicon glyphicon-log-out"></span>Log out</a> --}}
              @if(Auth::user())
                  <a class="btn btn-primary" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>
                     {{ __('Logout') }}
                  </a>
              @endif
  		      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  		          @csrf
  		      </form>
          </div>
      {{-- </div> --}}
    </div>
  </div>
