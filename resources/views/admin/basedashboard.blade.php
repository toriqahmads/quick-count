<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('img/favicon.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Tabulasi Suara Demak
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

<body id="content">
  <div class="wrapper ">
    <div class="sidebar" data-color="demokrat">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="{{ url('/admin') }}" class="simple-text logo-mini">
          Tab.
        </a>
        <a href="{{ url('/admin') }}" class="simple-text logo-normal">
          Demak
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav" id="sidemenus">
          <li id="dashboard">
            <a href="{{ url('/admin') }}" class="sidemenu">
              <i class="now-ui-icons shopping_shop"></i>
              <p>Home</p>
            </a>
          </li>
          <li id='tabulasi'>
            <a href="{{ url('/tabulasi/view') }}" class="sidemenu">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Tabulasi</p>
            </a>
          </li>
          
          <li id='seat'>
            <a data-toggle="collapse" href="#hitungkursi" role="button" aria-expanded="false" aria-controls="hitungkursi" class="sidemenu">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p>Hitung Kursi</p>
            </a>
          </li>
          <div class="collapse" id="hitungkursi">
            <li>
              <a href="{{ url('/kursi/e') }}" class="sidemenu">
                <i class="now-ui-icons education_hat"></i>
                <p>DPR Kab.</p>
              </a>
            </li>
            <li>
              <a href="{{ url('/kursi/d') }}" class="sidemenu">
                <i class="now-ui-icons education_hat"></i>
                <p>DPR Prov.</p>
              </a>
            </li>
            <li>
              <a href="{{ url('/kursi/c') }}" class="sidemenu">
                <i class="now-ui-icons education_hat"></i>
                <p>DPR RI</p>
              </a>
            </li>
          </div>

          <li id='listcaleg'>
            <a data-toggle="collapse" href="#caleg" role="button" aria-expanded="false" aria-controls="caleg" class="sidemenu">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p>Caleg</p>
            </a>
          </li>
          <div class="collapse" id="caleg">
            <li>
              <a href="{{ url('/caleg/listcaleg') }}" class="sidemenu">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p>Data Caleg</p>
              </a>
            </li>
            <li id='inputcaleg'>
              <a href="{{ url('/caleg/register') }}" class="sidemenu">
                <i class="now-ui-icons users_single-02"></i>
                <p>Input Data Caleg</p>
              </a>
            </li>
          </div>

          <li id='listsaksi'>
            <a data-toggle="collapse" href="#saksimenu" role="button" aria-expanded="false" aria-controls="saksimenu" class="sidemenu">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Saksi</p>
            </a>
          </li>
          <div class="collapse" id="saksimenu">
            <li>
              <a href="{{ url('/saksi/listsaksi') }}" class="sidemenu">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p>Data Saksi</p>
              </a>
            </li>
            <li id='inputsaksi'>
              <a href="{{ url('/saksi/register') }}" class="sidemenu">
                <i class="now-ui-icons business_badge"></i>
                <p>Input Data Saksi</p>
              </a>
            </li>
          </div>

          <li id='listpartai'>
            <a data-toggle="collapse" href="#partai" role="button" aria-expanded="false" aria-controls="partai" class="sidemenu">
              <i class="now-ui-icons business_bank"></i>
              <p>Partai</p>
            </a>
          </li>
          <div class="collapse" id="partai">
            <li>
              <a href="{{ url('/partai/listpartai') }}" class="sidemenu">
                <i class="now-ui-icons business_bank"></i>
                <p>Data Partai</p>
              </a>
            </li>
            <li id='inputpartai'>
              <a href="{{ url('/partai/register') }}" class="sidemenu">
                <i class="now-ui-icons design-2_ruler-pencil"></i>
                <p>Input Partai</p>
              </a>
            </li>
          </div>

          <li id='listtps'>
            <a data-toggle="collapse" href="#tpsmenu" role="button" aria-expanded="false" aria-controls="tpsmenu" class="sidemenu">
              <i class="now-ui-icons design_app"></i>
              <p>TPS</p>
            </a>
          </li>
          <div class="collapse" id="tpsmenu">
            <li>
              <a href="{{ url('/tps/listtps') }}" class="sidemenu">
                <i class="now-ui-icons design_app"></i>
                <p>Data TPS</p>
              </a>
            </li>
            <li id='inputtps'>
              <a href="{{ url('/tps/register') }}" class="sidemenu">
                <i class="now-ui-icons design-2_ruler-pencil"></i>
                <p>Input Data TPS</p>
              </a>
            </li>
          </div>

          <li id='suaraperdesa'>
            <a data-toggle="collapse" href="#suaradesa" role="button" aria-expanded="false" aria-controls="suaradesa" class="sidemenu">
              <i class="now-ui-icons files_paper"></i>
              <p>Suara Desa</p>
            </a>
          </li>
          <div class="collapse" id="suaradesa">
            <li>
              <a data-toggle="collapse" href="#datasuaradesa" role="button" aria-expanded="false" aria-controls="datasuaradesa" class="sidemenu">
                <i class="now-ui-icons files_paper"></i>
                <p>Data Suara Desa</p>
              </a>
            </li>
            <div class="collapse" id="datasuaradesa">
              <li>
                <a href="{{ url('/suara/desa/view/a') }}" class="sidemenu">
                  <i class="now-ui-icons files_paper"></i>
                  <p>Data Suara Presiden</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/view/b') }}" class="sidemenu">
                  <i class="now-ui-icons files_paper"></i>
                  <p>Data Suara DPD</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/view/c') }}" class="sidemenu">
                  <i class="now-ui-icons files_paper"></i>
                  <p>Data Suara DPR RI</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/view/d') }}" class="sidemenu">
                  <i class="now-ui-icons files_paper"></i>
                  <p>Data Suara DPR Prov.</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/view/e') }}" class="sidemenu">
                  <i class="now-ui-icons files_paper"></i>
                  <p>Data Suara DPR Kab.</p>
                </a>
              </li>
            </div>

            <li>
              <a data-toggle="collapse" href="#inputsuaradesa" role="button" aria-expanded="false" aria-controls="inputsuaradesa" class="sidemenu">
                <i class="now-ui-icons ui-1_check"></i>
                <p>Input Suara Desa</p>
              </a>
            </li>
            <div class="collapse" id="inputsuaradesa">
              <li>
                <a href="{{ url('/suara/desa/register/a') }}" class="sidemenu">
                  <i class="now-ui-icons ui-1_check"></i>
                  <p>Input Suara Presiden</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/register/b') }}" class="sidemenu">
                  <i class="now-ui-icons ui-1_check"></i>
                  <p>Input Suara DRD</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/register/c') }}" class="sidemenu">
                  <i class="now-ui-icons ui-1_check"></i>
                  <p>Input Suara DRP RI</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/register/d') }}" class="sidemenu">
                  <i class="now-ui-icons ui-1_check"></i>
                  <p>Input Suara DRP Prov.</p>
                </a>
              </li>
              <li>
                <a href="{{ url('/suara/desa/register/e') }}" class="sidemenu">
                  <i class="now-ui-icons ui-1_check"></i>
                  <p>Input Suara DRP Kab.</p>
                </a>
              </li>
            </div>
          </div>

          <li id='datasuara'>
            <a data-toggle="collapse" href="#suara" role="button" aria-expanded="false" aria-controls="suara" class="sidemenu">
              <i class="now-ui-icons files_paper"></i>
              <p>Suara</p>
            </a>
          </li>
          <div class="collapse" id="suara">
            <li>
              <a href="{{ url('/suara/view') }}" class="sidemenu">
                <i class="now-ui-icons files_paper"></i>
                <p>Data Suara</p>
              </a>
            </li>
            <li id='inputsuara'>
              <a href="{{ url('/suara/register') }}" class="sidemenu">
                <i class="now-ui-icons ui-1_check"></i>
                <p>Input Suara</p>
              </a>
            </li>
          </div>
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
            <a class="navbar-brand" href="#pablo">Tabulasi Suara Demak 2019</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <!--<li class="nav-item">
                <a class="nav-link" href="{{ url('/admin/editProfile') }}">
                  <i class="now-ui-icons users_circle-08" rel="tooltip" title="Edit Profile"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Edit Profile</span>
                  </p>
                </a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin/logout') }}">
                  <i class="now-ui-icons media-1_button-power" rel="tooltip" title="Logout"></i>
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
          <!--<nav>
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
          </nav>-->
          <div class="copyright">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, Designed by
            <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
            <a href="#" target="_blank">YouKnowWho</a>.
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
      if(window.location.href.indexOf('admin') > -1)
      {
        $("#dashboard").addClass('active');
      }
      else if(window.location.href.indexOf('saksi') > -1)
      {
        $("#listsaksi").addClass('active');
      }
      else if(window.location.href.indexOf('caleg') > -1)
      {
        $("#listcaleg").addClass('active');
      }
      else if(window.location.href.indexOf('tps') > -1 )
      {
        $("#listtps").addClass('active');
      }
      else if(window.location.href.indexOf('suara') > -1 )
      {
        $("#datasuara").addClass('active');
      }
      else if(window.location.href.indexOf('partai') > -1 )
      {
        $("#listpartai").addClass('active');
      }
      else if(window.location.href.indexOf('tabulasi') > -1 )
      {
        $("#tabulasi").addClass('active');
      }
      else if(window.location.href.indexOf('desa') > -1 )
      {
        $("#suaraperdesa").addClass('active');
      }
      else if(window.location.href.indexOf('kursi') > -1 )
      {
        $("#seat").addClass('active');
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
  <!--<script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>-->
  <!--  Notifications Plugin    -->
  <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/now-ui-dashboard.min.js?v=1.1.0') }}" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
</body>

</html>
