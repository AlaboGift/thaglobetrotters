<form method="GET" action="{{ url('/packages')}}"
    class="d-flex align-items-center shadow-sm rounded-5 mt-3 overflow-hidden bg-white p-2">

    <!-- Search Icon -->
    <span class="ps-4 pe-3 text-muted">
        <i class="bx bx-search"></i>
    </span>

    <!-- Input Field -->
    <input type="text" name="search" class="form-control border-0 shadow-none text-dark"
        placeholder="Find curated experiences and places" aria-label="Search destinations"
        style="outline: none !important;">

    <input type="hidden" name="type" value="{{request()->get('type')}}">
    <input type="hidden" name="category" value="{{request()->get('category')}}">

    <!-- Search Button -->
    <button class="btn btn-primary text-white rounded-pill me-2" type="submit">
        Search
    </button>
</form>
