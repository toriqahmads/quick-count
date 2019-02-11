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
          <h5 class="title">Registrasi Data TPS</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/tps/registerPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12 px-1">
                <div class="form-group">
                  <label>Nama TPS</label>
                  <input type="text" name="tps" class="form-control" id='ntps' placeholder="Nama TPS" value="{{ old('tps') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Provinsi</label>
                  <select name="prov" id="prov" class="form-control">
                    <option value="0" selected>Pilih Provinsi</option>
                    @foreach($data as $d)
                      <option value="{{$d->id}}">{{$d->prov}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3 px-1">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kab" id="kab" class="form-control">
                      <option value="0" selected>Pilih Kabupaten</option>
                    </select>
                  </div>
              </div>
              <div class="col-md-3 px-1">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec" id="kec" class="form-control">
                      <option value="0" selected>Pilih Kecamatan</option>
                    </select>
                  </div>
              </div>
              <div class="col-md-3 px-1">
                    <label>Kelurahan</label>
                    <select name="kel" id="kel" class="form-control">
                      <option value="0" selected>Pilih Kelurahan</option>
                    </select>
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