<div class="table-responsive text-nowrap" style="height: 100vh">

  <table class="table">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Package</th>
        <th>Price</th>
        <th>Category</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
      @forelse ($packages as $package)
      <x-table-package :package="$package" :loop="$loop" />
      @empty
        <tr>
          <td colspan="6">
            <div class="alert alert-dismissible alert-info m-4">
              No Data available
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="p-3 pagination">
  {{ $packages->links() }}
</div>
