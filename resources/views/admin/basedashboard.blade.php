<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('img/favicon.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Quick Count Demak
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/now-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet" />
  <link href="{{ asset('css/pagination.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet" />
  <script src="{{ asset('js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/sortTable.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/searchInTables.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery-confirm.min.js') }}" type="text/javascript"></script>
  
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          QCount
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Demak
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav" id="sidemenus">
          <li id="dashboard">
            <a href="{{ url('/admin') }}" class="sidemenu">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li id='tabdapil'>
            <a href="{{ url('/tabulasi/dapil') }}" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Tabulasi by Dapil</p>
            </a>
          </li>
          <li id='tabtps'>
            <a href="{{ url('/tabulasi/tps') }}" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Tabulasi by TPS</p>
            </a>
          </li>
          <li id='listcaleg'>
            <a href="{{ url('/caleg/listcaleg') }}" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Data Caleg</p>
            </a>
          </li>
          <li id='listsaksi'>
            <a href="{{ url('/saksi/listsaksi') }}" class="sidemenu">
              <i class="now-ui-icons users_single-02"></i>
              <p>Data Saksi</p>
            </a>
          </li>
          <li id='listpartai'>
            <a href="{{ url('/partai/listpartai') }}" class="sidemenu">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Data Partai</p>
            </a>
          </li>
          <li id='listtps'>
            <a href="{{ url('/tps/listtps') }}" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Data TPS</p>
            </a>
          </li>
          <li id='datasuara'>
            <a href="{{ url('/suara/view') }}" class="sidemenu">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Data Suara</p>
            </a>
          </li>
          <li id='inputcaleg'>
            <a href="{{ url('/caleg/register') }}" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Input Data Caleg</p>
            </a>
          </li>
          <li id='inputsaksi'>
            <a href="{{ url('/saksi/register') }}" class="sidemenu">
              <i class="now-ui-icons users_single-02"></i>
              <p>Input Data Saksi</p>
            </a>
          </li>
          <li id='inputpartai'>
            <a href="{{ url('/partai/register') }}" class="sidemenu">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Input Partai</p>
            </a>
          </li>
          <li id='inputtps'>
            <a href="{{ url('/tps/register') }}" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Input Data TPS</p>
            </a>
          </li>
          <li id='inputsuara'>
            <a href="{{ url('/suara/register') }}" class="sidemenu">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Input Suara</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Quick Count Demak 2019</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin/logout') }}">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Logout</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
        @yield('content')
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, Designed by
            <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <!--
  <script type="text/javascript">
    $(document).ready(function()
    {
        $("a.sidemenu").click(function(e)
        {
            e.preventDefault();
            urls = $(this).attr("href");
            li = $(this).parent();
            $("#contents").load(response);
            $("[class='active']").removeClass("active");
            li.attr("class", "active");
            return false;
        });
      });
  </script>-->
  <script type="text/javascript">
      var pathname = window.location.pathname;
      //alert(pathname);
      if(pathname == '/admin')
      {
        $("#dashboard").addClass('active');
      }
      else if(pathname == '/saksi/listsaksi')
      {
        $("#listsaksi").addClass('active');
      }
      else if(pathname == '/caleg/listcaleg')
      {
        $("#listcaleg").addClass('active');
      }
      else if(pathname == '/saksi/register')
      {
        $("#inputsaksi").addClass('active');
      }
      else if(pathname == '/caleg/register')
      {
        $("#inputcaleg").addClass('active');
      }
      else if(pathname == '/tps/register')
      {
        $("#inputtps").addClass('active');
      }
      else if(pathname == '/tps/listtps')
      {
        $("#listtps").addClass('active');
      }
      else if(pathname == '/suara/view')
      {
        $("#datasuara").addClass('active');
      }
      else if(pathname == '/suara/register')
      {
        $("#inputsuara").addClass('active');
      }
      else if(pathname == '/partai/register')
      {
        $("#inputpartai").addClass('active');
      }
      else if(pathname == '/partai/listpartai')
      {
        $("#listpartai").addClass('active');
      }
      else if(pathname == '/tabulasi/dapil')
      {
        $("#tabdapil").addClass('active');
      }
      else if(pathname == '/tabulasi/tps')
      {
        $("#tabtps").addClass('active');
      }
      else
      {
        $("#dashboard").addClass('active');
      }
  </script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
  <!--  Google Maps Plugin    -->
  <!-- Chart JS -->
  <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/now-ui-dashboard.min.js?v=1.1.0') }}" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
</body>

</html>
