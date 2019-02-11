@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('js/getreg.js')}}" type="text/javascript"></script>
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
<script type="text/javascript">
  $("#partai").change(function()
        {
            var gender = $("#partai").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap isi nama Partai!', 'danger');
            }
            else
            {
                return false;
            }
        });
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
          <h5 class="title">Registrasi Data Partai</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/partai/registerPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nama Partai</label>
                  <input type="text" name="partai" class="form-control" id='partai' placeholder="Nama Partai" value="{{ old('partai') }}">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nomor urut</label>
                  <input type="number" name="no_urut" class="form-control" id='no_urut' placeholder="Nomor urut" value="{{ old('no_urut') }}">
                </div>
              </div>
          </div>
        <div class="row">
            <div class="col-md-6 pl-1">
                <div class="form-group">
                    <label>Foto Partai</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse… <input type="file" name="foto" id="imgInp">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pr-1">
              <label>Preview</label>
              <div class="form-group">
                
                <img id='img-upload'/>
              </div>
            </div>
          </div>
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Submit" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection