@extends('layouts.auth')
@section('content')
   <!-- Error -->
   <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">Forbidden!</h2>
            <p class="mb-4 mx-2">Action is not allowed on this page.</p>
            <a href="{{url('/')}}" class="btn btn-primary">Back to home</a>
            <div class="mt-4">
              <img
                src="../assets/img/illustrations/girl-doing-yoga-light.png"
                alt="girl-doing-yoga-light"
                width="500"
                class="img-fluid"
                data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                data-app-light-img="illustrations/girl-doing-yoga-light.png"
              />
            </div>
          </div>
      </div>
   </div>
      <!-- /Error -->
@endsection
    