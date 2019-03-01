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
              <img class="avatar border-gray" src="{{ asset('img/saksi/default_avatar.jpg') }}" alt="...">
              <h5 class="title">{{ Session::get('nama_depan') }} {{ Session::get('nama_belakang') }}</h5>
            </a>
            <p>{{Session::get('hp') }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection