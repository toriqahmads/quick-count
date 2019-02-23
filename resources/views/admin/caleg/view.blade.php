@extends('admin.basedashboard')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-user">
        <div class="image">
          <img src="{{ asset('img/bg5.jpg') }}" alt="...">
        </div>
        <div class="card-body">
          <div class="author">
            <a href="#">
              <img class="avatar rounded-circle img-raised" src="{{ asset('img/caleg') }}/{{ $data->foto }}" alt="...">
              <h5 class="title">{{ $data->nama_depan }} {{ $data->nama_belakang }}</h5>
            </a>
          </div>
          @if(isset($data->id_prov))
          <p class="description">
              Provinsi : @foreach($provinsi as $p) @if($data->id_prov == $p->id){{$p->prov}}@endif @endforeach
          </p>
          @endif
          @if(isset($data->id_kab))
          <p class="description">
              Kabupaten : @foreach($kab as $k) @if($data->id_kab == $k->id){{$k->kab}}@endif @endforeach
          </p>
          @endif
          @if(isset($data->id_kec))
          <p class="description">
              Kecamatan : @foreach($kec as $kec) @if($data->id_kec == $kec->id_kec){{$kec->kec}}@endif @endforeach
          </p>
          @endif
          @if(isset($data->id_dapil))
          <p class="description">
              Dapil : @foreach($dapil as $dap) @if($data->id_dapil == $dap->id){{$dap->dapil}}@endif @endforeach
          </p>
          @endif
          <p class="description">
            Tingkat :
            @if($data->tingkat == 'a')
              Presiden
            @elseif($data->tingkat == 'b')
              DPD
            @elseif($data->tingkat == 'c')
              DPR RI
            @elseif($data->tingkat == 'd')
              DPR Provinsi
            @else
              DPR Kabupaten
            @endif
          </p>
          <p class="description">
            Partai : {{$data->partai}}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection