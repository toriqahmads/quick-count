@extends('admin.basedashboard')
@section('content')
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="title">Edit Data Saksi</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="card card-user">
					        <div class="image">
					          <img src="{{ asset('img/bg5.jpg') }}" alt="...">
					        </div>
						        <div class="card-body">
						          	<div class="author">
						            	<a href="">
						              	<img class="avatar border-gray" src="{{ asset('img/') }}/{{$data->foto}}" alt="...">
						            	</a>
						        	</div>
					    		</div>
						</div>
					</div>
					<div class="row">
	                	<div class="form-group col-md-12">
	                		<label>NIK (Username)</label>
	                		<input type="number" class="form-control" placeholder="Masukkan Nomor Induk" value="{{ $data->nik }}">
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>No. HP</label>
                  			<input type="text" name="telp" class="form-control" placeholder="No. HP" value="{{ $data->telp }}">
	                	</div>
	                </div>
					<div class="row">
						<div class="form-group col-md-6">
							<label>Nama Depan</label>
	                        <input type="text" value="{{ $data->nama_depan }}" placeholder="Masukkan Nama Depan" class="form-control">
	                    </div>
	                    <div class="form-group col-md-6">
							<label>Nama Belakang</label>
	                        <input type="text" value="{{ $data->nama_belakang }}" placeholder="Masukkan Nama Belakang" class="form-control">
	                    </div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Jenis Kelamin</label>
	                        <select name="" id="" class="form-control">
	                        	<option value="l">laki-laki</option>
	                        	<option value="p">perempuan</option>
	                        </select>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Alamat</label>
	                        <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Provinsi</label>
	                		<select name="prov" class="form-control" id="prov">
				                <option value="{{ $data->id_prov }}">{{ $data->prov }}</option>
				            </select>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Kabupaten</label>
	                		<select name="kab" class="form-control" id="kab">
			                    <option value="{{ $data->id_kab }}">{{ $data->kab }}</option>
			                </select>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Kecamatan</label>
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
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Kelurahan</label>
	                		<select name="kel" class="form-control" id="kel">
	                		<option value="0">Kelurahan</option>
			                    @foreach($kels as $kel)
									@if($kel->kel != $data->kel)
										<option value="{{ $kel->id_kel }}">{{ $kel->kel }}</option>
									@else
										<option value="{{ $kel->id_kel }}" selected>{{ $kel->kel }}</option>
									@endif
			                    @endforeach
		                    </select>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>TPS</label>
	                		<select name="tps" class="form-control" id="tps">
		                    <option value="0">TPS</option>
		                    @foreach($tps as $tpss)
								@if($tpss->tps != $data->tps)
									<option value="{{ $tpss->id_tps }}">{{ $tpss->tps }}</option>
								@else
									<option value="{{ $tpss->id_tps }}" selected>{{ $tpss->tps }}</option>							  
								@endif
		                    @endforeach
		                  </select>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="form-group col-md-12">
	                		<label>Dapil</label>
                 			 <input id="dapil" name="dapil" type="text" class="form-control" placeholder="Dapil" value="{{ $data->id_dapil }}">
	                	</div>
	                </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection