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
              <img class="avatar border-gray" src="{{ asset('img/') }}/" alt="...">
              <h5 class="title">{{ $data }} </h5>
            </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection