@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('js/getreg.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/suara.js')}}" type="text/javascript"></script>
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
  	<div class="col-md-12">
      <div class="card">
      	<div class="card-body">
	    <div class="row">
	  	<div class="col-md-3 px-1">
	       <div class="form-group">
	            <label>Kecamatan</label>
	            <select name="kec" id="kec" class="form-control">
	              <option value="0" selected>Kecamatan</option>
	              @foreach($kec as $kecs)
	              <option value="{{ $kecs->id_kec }}">{{ $kecs->kec }}</option>
	              @endforeach
	            </select>
	          </div>
	      </div> 
	      <div class="col-md-3 px-1">
	      	<div class="form-group">
	          <label>Kelurahan</label>
	          <select name="kel" id="kel" class="form-control">
	            <option value="0" selected>Kelurahan</option>
	          </select>
	      </div>
	      </div>
	  	  <div class="col-md-3 px-1">
	  	  	<div class="form-group">
	          <label>TPS</label>
	            <select name="tps" id="tps" class="form-control">
	              <option value="0" selected>TPS</option>
	            </select>
	        </div>
	   	  </div>
	   	  <div class="col-md-3 px-1">
	   	  	<div class="form-group">
	          <label>Dapil</label>
	            <select name="dapil" id="dapil" class="form-control">
	              <option value="0" selected>Dapil</option>
	              @foreach($dapil as $dap)
	                  <option value="{{ $dap->id }}">{{ $dap->id }}</option>
	              @endforeach
	            </select>
	        </div>
	   	  </div>
	   	</div>
	   	</div>
   	</div>
   </div>

   @foreach($partai as $part)
   <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h5 class="title">{{$part->partai}}</h5>
        </div>
        <div class="card-body">
          <form id="suara{{$part->id}}" class="form" method="post" action="{{ url('/admin/suara/registerPostSuara') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12 pl-1">
                <div class="form-group">
                  <label>{{$part->partai}}</label>
                  <input type="text" name="suarapartai[{{$part->id}}]" class="form-control" placeholder="Suara Partai" value="{{ old('suara.$part->id.$part->id') }}">
                </div>
              </div>
              <div class="col-md-12 pl-1" id="{{$part->id}}">
              </div>
          	</div>
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="kirim btn-primary btn btn-round btn-block" value="Kirim" />
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
<script src="{{ asset('js/kirim-suara.js')}}" type="text/javascript"></script>
@endsection