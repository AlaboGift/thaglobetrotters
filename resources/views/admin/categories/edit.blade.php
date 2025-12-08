@extends('layouts.admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h4>{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('admin/categories/edit/' . $category->id) }}" method="post"
                            enctype="multipart/form-data">
                            <div class="notification">
                                <x-notification />
                            </div>
                            @csrf
                            @include('admin.categories._form')

                            <div class="d-flex justify-content-end">
                                <a href="{{ url('admin/categories') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Request</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script>
        $(functtion() {
            function changeTitleOfImageUploader(photoElem) {
                var fileName = $(photoElem).val().replace(/C:\\fakepath\\/i, '');
                $(photoElem).siblings('label').text(ellipsis(fileName));
            }

            function ellipsis(str, length, ending) {
                if (length == null) {
                    length = 40;
                }
                if (ending == null) {
                    ending = '...';
                }
                if (str.length > length) {
                    return str.substring(0, length - ending.length) + ending;
                } else {
                    return str;
                }
            }
        })
    </script>
@endpush
