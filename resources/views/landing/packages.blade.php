@extends('layouts.landing')
@section('content')
    <section style="border-top: 1px solid #CCCCCC;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 mt-2">
                    <x-search-form/>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container">
            <h2>{{ $title }}</h2>
            <div class="row align-items-center mt-xl-3">
                @foreach ($packages as $package)
                    <x-package :package="$package" />
                @endforeach
            </div>
        </div>
    </section>
@endsection
