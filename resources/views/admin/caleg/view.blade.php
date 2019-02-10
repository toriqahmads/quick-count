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
          <p class="description">
            
          </p>
          <p class="description">
              Dapil : @foreach($dapil as $dap) @if($data->id_dapil == $dap->id){{$dap->dapil}}@endif @endforeach
          </p>
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