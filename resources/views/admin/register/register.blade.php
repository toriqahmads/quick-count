@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('js/getreg.js') }}"></script>
<script type="text/javascript">
            function showNotification(from, align, msg, color){
    color = color

    $.notify({
        icon: "now-ui-icons ui-1_bell-53",
        message: msg

      },{
          type: color,
          timer: 8000,
          placement: {
              from: from,
              align: align
          }
      });
        };
</script>
@if(\Session::has('alert'))
    <script type="text/javascript">
        $(document).ready(function(){
            showNotification('top', 'right', '{!! Session::get('alert') !!}', 'danger');
        });
    </script>
@endif

@if(\Session::has('alert-success'))
    <script type="text/javascript">
        $(document).ready(function(){
            showNotification('top', 'right', '{!! Session::get('alert-success') !!}', 'success');
        });
    </script>
@endif

@if ($errors->any())
    <?php $err = '<ul>';
        foreach ($errors->all() as $error)
        {
            $err .= '<li>'. $error .'</li>';
        }
        
        $err .= '</ul>';
    ?>

    <script type="text/javascript">
        $(document).ready(function(){
            showNotification('top', 'right', '<?php echo $err; ?>', 'danger');
        });
    </script>
@endif
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Register Admin</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/admin/registerAdminPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nama Depan</label>
                  <input type="text" name="fname" class="form-control" placeholder="Nama Depan" value="{{ old('fname') }}">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nama Belakang</label>
                  <input type="text" name="lname" class="form-control" placeholder="Nama Belakang" value="{{ old('lname') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="text" name="telp" placeholder="Nomor HP" class="form-control" value="{{ old('telp') }}">
                </div>
              </div>
            </div>
          <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Konfirmasi Password</label>
                  <input type="password" name="confirmation" placeholder="Confirm Password" class="form-control" />
                </div>
              </div>
          </div>
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Registrasi" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection