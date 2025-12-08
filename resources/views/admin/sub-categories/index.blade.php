@extends('layouts.admin')
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div>
              <h4 class="mb-0">{{ $title }}</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3">
              <a class="btn btn-primary" href="{{ url('admin/sub-categories/create') }}"> <i class="fa fa-plus me-1"></i>
                Add SubCategory</a>
              <form method="GET" action="{{ url('admin/sub-categories') }}">
                <div class="input-group input-group-merge">
                  <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                  <input value="{{ request('search') }}" name="search" type="text" class="form-control"
                    placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                </div>
              </form>

              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bx bx-filter"></i>
                </button>
                <div class="dropdown-menu" style="">
                  <form class="w-100 p-4" method="GET" action="{{ url('admin/sub-categories') }}">
                    @include('admin.partials.filter')
                  </form>
                </div>
              </div>

            </div>

          </div>

          @include('admin.sub-categories._table')

        </div>
      </div>
    </div>
  </div>
@endsection
