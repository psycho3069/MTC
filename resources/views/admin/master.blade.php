<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Aspada</title>

      <!------Add-favicon------->
      <link rel="icon" href="/img/mtclogo.png">

    <!-- Bootstrap -->
    <link href="{{asset('bs4')}}/css/bootstrap.css" rel="stylesheet">
    <link href="{{asset('admin')}}/css/customnav.css" rel="stylesheet">
    <link href="{{asset('admin')}}/css/dash.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/date.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />

{{--    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
{{--    <link href="{{asset('css')}}/treeview.css" rel="stylesheet">--}}
    <!-- treeview end -->
@yield('style')
@yield('header_styles')
      <style>
          input[type="number"] {
              height: auto;
          }
      </style>
   </head>

   <body>
    <div id="app">

        @include('admin.inc.header')

        @if(Auth::user())
            @include('admin.inc.navbar')
        @endif


        <div class="row">
            <div class="col-md-8 text-center" style="margin-left: 16%;">
                <code>@include('admin.inc.notification')</code>
            </div>
        </div>






        <main class="py-4">
            @yield('rooms')

            <div class="content">
                @yield('reports')

            </div>

            <div align="center">
                @yield('content')
            </div>
        </main>

        <div class="subfooter" style="background: #1f9bcc; color: #fff; padding-top: 20px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="copyrights">&copy; 2019 MTC | Design &amp; Developed by <a href="http://mien-it.com/" target="_blank" style="color: #fff;"><b>MIEN IT</b></a></div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="social-media pull-right">
                            <a class="facebook" target="_blank" data-original-title="Aspada" data-toggle="tooltip" href="https://aspada.org.bd/">
                                <img src="{{ asset('img/mtclogo.png') }}" alt="Aspada" style="width: 33px; padding-bottom: 10px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery -->
{{--    <script src="{{asset('bs4')}}/js/jquery.js"></script>--}}
    <script src="{{asset('bs4')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('bs4')}}/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    @yield('datatable')
    <!-- bootbox -->

    <script type="text/javascript" src="{{asset('admin')}}/dist/js/bootbox.min.js"></script>
    <script type="text/javascript">

        $(document).on("click", "#delete", function(e){
            e.preventDefault();
            var link = $(this).attr("href");
            bootbox.confirm("Do you want to delete it?", function(confirmed){
                if(confirmed) {
                    window.location.href = link;
                };
            });
        });
    </script>


    <!-- datepicker -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.navbar-dark .dmenu').hover(function () {
                $(this).find('.sm-menu').first().stop(true, true).slideDown(150);
            }, function () {
                $(this).find('.sm-menu').first().stop(true, true).slideUp(105)
            });
        });
    </script>


    <script>
        $(".date").on("change", function() {
            this.setAttribute(
                "data-date",
                moment(this.value, "YYYY-MM-DD")
                    .format( 'DD-MM-YYYY' )
            )
        }).trigger("change")
    </script>



    <!-- treeview start -->
{{--    <script src="{{asset('js')}}/treeview.js"></script>--}}

    @yield('footer_scripts')
    @yield('script')
    <!-- treeview end -->
</body>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
</html>

@yield('customscript')

