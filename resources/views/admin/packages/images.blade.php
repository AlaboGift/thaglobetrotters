@extends('layouts.admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="mb-4">
            <a href="{{url('admin/packages')}}"><i class="bx bx-chevron-left"></i> Back to Packages</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h4>{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <form action="{{ url('admin/packages/images', $package->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                <div class="notification">
                                    <x-notification />
                                </div>
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <label for="image" class="form-label">Upload Package Image</label>
                                        <input class="form-control" type="file" name="file" id="image" required>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            @foreach($package->images as $image)
                            
                                <div class="col-sm-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <div class="p-2">
                                            <img class="card-img-top" src="{{ $image->getURL() }}" alt="{{$image->name}}">
                                        </div>
                                        <div class="p-3 d-flex justify-content-between">
                                            <div>
                                                <h5 class="card-title">{{$image->name}}</h5>
                                                <p class="card-text">{{$image->created_at->format('M d, Y')}}</p>
                                            </div>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">
                                                    @if(!$image->is_default)
                                                        <a class="dropdown-item" href="{{ url('admin/packages/images/' . $image->id. '/default') }}"><i class="bx bx-edit-alt me-1"></i> Make Default</a>
                                                    @endif
                                                        <a class="dropdown-item confirm" href="{{ url('admin/packages/images/' . $image->id. '/delete') }}"><i class="bx bx-trash me-1"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  @endsection