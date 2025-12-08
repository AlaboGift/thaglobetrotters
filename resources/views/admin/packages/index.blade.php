@extends('layouts.admin')
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div
            class="card-header d-flex flex-column flex-md-row align-items-start align-items-sm-center justify-content-between">
            <div>
              <h4 class="mb-0">{{ $title }}</h4>
            </div>
            <div
              class="d-flex flex-wrap justify-content-around justify-content-sm-between flex-column flex-md-row align-items-center gap-3">
              <a class="btn btn-primary me-3" href="{{ url('admin/packages/create?type='.request()->get('type')) }}"> <i class="fa fa-plus me-1"></i>
                Create Package</a>
              <form method="GET" action="{{ url('admin/packages') }}">
                <div class="input-group input-group-merge">
                  <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                  <input value="{{ request('search') }}" name="search" type="text" class="form-control"
                    placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                </div><input type="hidden" value="{{request()->get('type')}}" name="type" />
              </form>
              <div>
                <a href="{{ url('admin/packages/set-layout/grid') }}"
                  class="btn {{ $layout == 'grid' ? 'btn-primary text-white' : 'btn-outline-secondary' }}"><i
                    class="bx bx-grid"></i></a>
                <a href="{{ url('admin/packages/set-layout/list') }}"
                  class="btn btn-outline-secondary {{ $layout == 'list' ? 'btn-primary text-white' : 'btn-outline-secondary' }}"><i
                    class="bx bx-menu"></i></a>

                <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-filter"></i>
                  </button>
                  <div class="dropdown-menu" style="">
                    <form class="w-100 p-4" method="GET" action="{{ url('admin/packages') }}">
                      @include('admin.partials.filter')
                      <input type="hidden" value="{{request()->get('type')}}" name="type" />
                    </form>
                  </div>
                </div>
                
              </div>
            </div>

          </div>
          @if ($layout == 'grid')
            @include('admin.packages._grid')
          @else
            @include('admin.packages._list')
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
