@extends('saksi.base')
@section('content')

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
            <div class="col-md-4 content-center">
                <div class="card card-login card-plain">
                    <form class="form" method="post" action="{{ url('/saksi/loginPost') }}">
                        <div class="header header-primary text-center">
                            <h4>Login Saksi</h4>
                        </div>
                        {{ csrf_field() }}
                        <div class="content">
                            <div class="input-group form-group-no-border input-lg">
                                <input type="text" name="username" class="form-control" placeholder="Username....">
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <input type="password" name="password" placeholder="Password..." class="form-control" />
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <input type="submit" class="btn-primary btn btn-round btn-block" value="Login" />
                            </div>

                            <div class="pull-left">
                            <h6>
                                <a href="{{ url('/saksi/reg') }}" class="link">Registrasi</a>
                            </h6>
                            </div>
                            <!--<div class="pull-right">
                                <h6>
                                    <a href="{{ url('/saksi/forgot') }}" class="link">Lupa password?</a>
                                </h6>
                            </div>-->
                    </form>
                        </div>
                </div>
            </div>
@endsection