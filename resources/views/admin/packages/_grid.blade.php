<div class="row p-3">
  @foreach ($packages as $package)
  <x-grid-package :package="$package"/>
  @endforeach
</div>
<div class="p-3 pagination">
  {{ $packages->links() }}
</div>
