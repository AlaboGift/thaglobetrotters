<div class="col-sm-6 col-lg-4 col-xl-3 mb-5">
    <div class="card rounded-4 border-0 shadow-sm position-relative">
        <a href="{{url('/package/'.$package->slug)}}"><img src="{{ $package->getImageUrl() }}"
                class="img-fluid rounded-top-3" style="width: 100%; height: 273px;" alt="image"></a>
        <div class="card-body p-3">

            <a href="{{url('/package/'.$package->slug)}}">
                <h6 class="course-title py-2 m-0">{{ $package->name }}</h6>
                <small class="text-muted">{!! $package->description !!}</small>
            </a>
            <p><i class="bx bx-calendar"></i> {{\Carbon\Carbon::parse($package->start_date)->format('jS M, Y')}} - {{\Carbon\Carbon::parse($package->end_date)->format('jS M, Y')}}</p>
            <x-package-rating :package="$package"/>
        </div>
    </div>
</div>
