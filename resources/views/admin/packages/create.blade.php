@extends('layouts.admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <div class="mb-4">
            <a href="{{url()->previous()}}"><i class="bx bx-chevron-left"></i> Back to Packages</a>
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

                        <form action="{{ url('admin/packages/store') }}" method="post" enctype="multipart/form-data">
                            <div class="notification">
                                <x-notification />
                            </div>
                            @csrf
                            @include('admin.packages._form')

                            <div class="d-flex justify-content-end">
                                <a href="{{ url('admin/packages') }}" class="btn btn-secondary me-2">Cancel</a>
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
        const testFields = $('#test-fields')

        $(".add-test").on('click', function(){
            $('.delete-btn').show();
            let data = $('#test-fields').children(0).html();
            testFields.append(data);
        })

        function deleteTest(e)
        {  
            console.log(testFields.children().length);
            if(testFields.children().length > 1)
            {
                $(e).parent().remove();
            }
        }
    </script>
@endpush
