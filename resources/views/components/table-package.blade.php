<tr>
    <td>{{ $loop->iteration }}</td>
    <td>
        <a href="{{ url('admin/packages/images', $package->id) }}">
            <img class="round-img" src="{{ $package->getImageUrl() }}" alt="Image Description" height="50" width="50" />
        </a>
    </td>
    <td>{{ $package->name}}</td>
    <td>${{ number_format($package->price) }}</td>
    <td>{{ $package->category->name ?? 'Others' }}</td>
    <td><span
            class="badge bg-label-{{ $package->status == 'ACTIVE' ? 'success' : 'danger' }} me-1">{{ $package->status }}</span>
    </td>
    <td>
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
    </td>
</tr>
