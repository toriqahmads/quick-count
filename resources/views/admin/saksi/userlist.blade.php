@extends('admin.basedashboard')
@section('content')

<div class="panel-header panel-header-sm">
</div>
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Simple Table</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>
                  Name
                </th>
                <th>
                  Country
                </th>
                <th>
                  City
                </th>
                <th class="text-right">
                  Year
                </th>
                <th class="text-right">
                  Salary
                </th>
                <th class="text-right">
                  Action
                </th>
              </thead>
              <tbody>
                @foreach($req as $data)
                {
                    <tr>
                        <td class="text-center">1</td>
                        <td>Andrew Mike</td>
                        <td>Develop</td>
                        <td>2013</td>
                        <td class="text-right">&euro; 99,225</td>
                        <td class="td-actions text-right">
                            <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                <i class="now-ui-icons users_single-02"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                <i class="now-ui-icons ui-2_settings-90"></i>
                            </button>
                            <form method="POST" action="{{ route('delete.saksi', [$data->nik, $data->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                  <i class="now-ui-icons ui-1_simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                }
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