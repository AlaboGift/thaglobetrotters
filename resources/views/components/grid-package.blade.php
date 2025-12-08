<div class="col-md-3 mb-4">
    <div class="card" style="border-radius: 20px;">
        <a class="crd-img-wrap position-relative"
            href="{{ url('admin/packages/images', $package->id) }}">
            <img class="img-fluid rounded-top-3" src="{{ $package->getImageUrl() }}" alt="Image Description"
                style="height: 180px; width: 100%;" />
        </a>
        <div class="crd-content p-3">
            <div class="d-flex justify-content-between">
                <small
                    style="background-color: #FAF3FE; padding: 4px; color: #AA39AA;">{{ ucwords($package['category_type']) }}</small>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                        @if($package->status == 'ACTIVE')
                            <a class="dropdown-item confirm" href="{{ url('admin/packages/publish/' . $package->id) }}"><i class="bx bx-hide me-1"></i>Unpublish</a>
                        @else
                            <a class="dropdown-item confirm" href="{{ url('admin/packages/publish/' . $package->id) }}"><i class="bx bx-show me-1"></i>Publish</a>
                        @endif
                        <a class="dropdown-item" href="{{ url('admin/packages/edit/' . $package->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <a class="dropdown-item confirm" href="{{ url('admin/packages/delete/' . $package->id) }}"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <h6 class="text-dark">{{ $package->name }}</h6>
                <p>${{ number_format($package->price) }}</p>
            </div>
        </div>
    </div>
</div>
