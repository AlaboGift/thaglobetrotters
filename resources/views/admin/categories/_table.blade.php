<div class="table-responsive text-nowrap" style="height: 100vh">
  @if ($categories->count())
    <table class="table">
      <thead class="table-dark">
        <tr>
          <th>&nbsp;</th>
          <th>Name</th>
          <th>Trip Type</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($categories as $key => $record)
          <tr>
            <td>
              <img src="{{ $record->image_url }}" height="50" width="50" />
            <td>
              {{ $record->name }}
            </td>
            <td>
              {{ $record->category_type }}
            </td>

            <td><span class="badge bg-label-{{$record->status == 'ACTIVE' ? 'success' : 'danger'}} me-1">{{ $record->status }}</span></td>
            <td>
              <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" style="">
                    <a class="dropdown-item" href="{{ url('admin/categories/edit/' . $record->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item confirm" href="{{ url('admin/categories/delete/' . $record->id) }}"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <div class="alert alert-dismissible alert-info m-4">
      No Data available
    </div>
  @endif
</div>
<div class="p-3 pagination">
  {{ $categories->links() }}
</div>
