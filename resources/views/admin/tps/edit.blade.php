@extends('admin.basedashboard')
@section('content')
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
          <h5 class="title">Edit Data TPS</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/admin/tps/updateTPS') }}">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label>Nama TPS</label>
                  <input type="text" name="tps" class="form-control" id='ntps' placeholder="Nama TPS" value="{{ $data->tps }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Provinsi</label>
                  <select name="prov" class="form-control" id="prov">
                    <option value="{{ $data->id_prov }}">{{ $data->prov }}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label>Dapil</label>
                  <input id="dapil" name="dapil" type="text" class="form-control" placeholder="Dapil" value="{{ $data->id_dapil }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pl-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Kabupaten</label>
                  <select name="kab" class="form-control" id="kab">
                    <option value="{{ $data->id_kab }}">{{ $data->kab }}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Kecamatan</label>
                  <select name="kec" class="form-control" id="kec">
                    <option value="0">Kecamatan</option>
                    @foreach($kecs as $kec)
                    {
                      @if($kec->kec != $data->kec)
                      {
                        <option value="{{ $kec->id_kec }}">{{ $kec->kec }}</option>
                      }
                      @else
                      {
                        <option value="{{ $kec->id_kec }}" selected>{{ $kec->kec }}</option>
                      }
                      @endif
                    }
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Kelurahan</label>
                  <select name="kel" class="form-control" id="kel">
                    <option value="0">Kelurahan</option>
                    @foreach($kels as $kel)
                    {
                      @if($kel->id_kel != $data->id_kel)
                      {
                        <option value="{{ $kel->id_kel }}">{{ $kel->kel }}</option>
                      }
                      @else
                      {
                        <option value="{{ $kel->id_kel }}" selected>{{ $kel->kel }}</option>
                      }
                      @endif
                    }
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
            </div>
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Simpan Perubahan" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection