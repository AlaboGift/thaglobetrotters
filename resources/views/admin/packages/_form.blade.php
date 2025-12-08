<h5>Basic Information</h5>
<hr/>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="title">Title</label>
    <div class="col-md-9">
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ $package->name }}">
    </div>
</div>

@if(!$type)
<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="category">Trip Type</label>
    <div class="col-md-9">
        <select name="category_type" id="inputPriority" class="form-control valid" aria-invalid="false">
            <option value="">--Select Trip Type--</option>
            @if (count($category_types) > 0)
                @foreach ($category_types as $category_type)
                    <option value="{{ $category_type }}" @if (old('category_type', $package->category_type) == $category_type) selected @endif>
                        {{ $category_type }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
@else
<input type="hidden" value="{{$type}}" name="category_type" />
@endif

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="category">Category</label>
    <div class="col-md-9">
        <select name="category" id="inputPriority" class="form-control valid" aria-invalid="false">
            <option value="">--Select Category--</option>
            @if (count($categories) > 0)
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if (old('category', $package->category_id) == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            @endif

        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="category">Sub-Category</label>
    <div class="col-md-9">
        <select name="sub_category" id="inputPriority" class="form-control valid" aria-invalid="false">
            <option value="">--Select Sub-Category--</option>
            @if (count($subcategories) > 0)
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" @if (old('sub_category', $package->sub_category_id) == $subcategory->id) selected @endif>
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            @endif

        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="price">Price</label>
    <div class="col-md-9">
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price', $package->price) }}">
    </div>
</div>

<h5>About Information</h5>
<hr/>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="description">Description</label>
    <div class="col-md-9">
        <textarea class="form-control note" name="description">{{ old('description', $package->description) }}</textarea>
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="included">Whats included</label>
    <div class="col-md-9">
        <textarea class="form-control note" name="included">{{ old('included', $package->included) }}</textarea>
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="excluded">Whats not included</label>
    <div class="col-md-9">
        <textarea class="form-control note" name="excluded">{{ old('excluded', $package->excluded) }}</textarea>
    </div>
</div>

<h5>Date Information</h5>
<hr/>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="start">Start Date</label>
    <div class="col-md-9">
        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
            value="{{ old('start_date', $package->start_date) }}">
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="start">End Date</label>
    <div class="col-md-9">
        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
            value="{{ old('end_date', $package->end_date) }}">
    </div>
</div>

<h5>Departure & Return</h5>
<hr/>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="start">Start Location</label>
    <div class="col-md-9">
        <input type="text" name="start" class="form-control @error('start') is-invalid @enderror"
            value="{{ old('start', $package->start) }}">
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="in_between">In Between</label>
    <div class="col-md-9">
        <textarea class="form-control note" name="in_between">{{ old('in_between', $package->in_between) }}</textarea>
    </div>
</div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="start">End Location</label>
    <div class="col-md-9">
        <input type="text" name="end" class="form-control @error('end') is-invalid @enderror"
            value="{{ old('end', $package->end) }}">
    </div>
</div>

<div class="d-flex justify-content-between mt-5">
    <h5>Itinerary</h5>
    <a role="button" class="btn btn-primary add-test btn-sm text-white"> Add Itinerary <i class="bx bx-plus"></i></a>
</div>
<hr/>

@if ($package->itineraries()->count())
@foreach ($package->itineraries as $item)
        <div id="test-fields">
            <div>
                <div class="form-group row mb-3">
                    <div class="col">
                        <label>Item</label>
                        <input type="text" name="titles[]" class="form-control @error('end') is-invalid @enderror" 
                            value="{{ $item->title }}">
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" name="descriptions[]" class="form-control @error('end') is-invalid @enderror"
                            value="{{ $item->description }}">
                    </div>
                    <a class='col delete-btn' onclick='deleteTest(this)' style="margin-top: 30px;"><i class='bx bx-trash text-danger'></i></a>
                </div>
            </div>
        </div>
@endforeach
@else
<div id="test-fields">
<div>
    <div class="form-group row mb-3">
        <div class="col">
            <label>Item</label>
            <input type="text" name="titles[]" class="form-control @error('end') is-invalid @enderror">
        </div>
        <div class="col">
            <label>Description</label>
            <input type="text" name="descriptions[]" class="form-control @error('end') is-invalid @enderror">
        </div>
        <a class='col delete-btn' onclick='deleteTest(this)' style="margin-top: 30px;"><i class='bx bx-trash text-danger'></i></a>
    </div>
</div>
</div>
@endif