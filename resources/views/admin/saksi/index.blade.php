@extends('admin.basedashboard')
@section('content')
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h6>Daftar Semua Saksi</h6>
					</div>
                    <div class="card-body">
                        <div class="tab-content">
	                        <table class="table table-stripped">
	                    		<thead>
	                    			<tr>
	                    				<th>#</th>
	                    				<th>Nama</th>
	                    				<th>Jenis Kelamin</th>
	                    				<th>NIK</th>
	                    				<th>Kelurahan</th>
	                    				<th>Kecamatan</th>
	                    				<th>Foto</th>
	                    			</tr>
	                    		</thead>  
	                    		<tbody>
	                    			@php $no = 1 @endphp
		                    		@foreach ($req as $value)
		                    			<tr>
		                    				<td>{{ $no++ }}</td>
		                    				<td>{{ $value->nama_depan }} {{ $value->nama_belakang }}</td>
		                    				@if ($value->gender == 'l')
		                    					<td>Laki-Laki</td>
		                    				@else
		                    					<td>Perempuan</td>
		                    				@endif
		                    				<td>{{ $value->nik }}</td>
		                    				<td>{{ $value->kel }}</td>
		                    				<td>{{ $value->kec }}</td>
		                    				<td><img class="avatar border-gray" src="{{ asset('img/') }}/{{$value->foto}}"></td>
		                    			</tr>
		                    		@endforeach
	                    		</tbody>
	                        </table> 
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
@endsection