<div class="form-group mb-3">
  <label for="name">Category Title<span class="required">*</span></label>
  <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required="">
  @error('name')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>


<div class="form-group mb-3">
  <label for="description">Category Description</label>
  <textarea class="form-control" name="description" id="description" required="" rows="6">{{ $category->description }} </textarea>
  @error('description')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>

<div class="form-group mb-3">
    <label for="description">Trip Type</label>
    <select name="category_type" id="inputPriority" class="form-control valid" aria-invalid="false">
        <option value="">--Select Trip Type--</option>
        @if (count($category_types) > 0)
            @foreach ($category_types as $category_type)
                <option value="{{ $category_type }}" @if ($category->category_type == $category_type) selected @endif>
                    {{ $category_type }}
                </option>
            @endforeach
        @endif
    </select>
    @error('category_type')
        <small class="text-danger col-md-12">{{ $message }}</small>
    @enderror
</div>

<div class="form-group mb-3" id="thumbnail-picker-area">
  <label> Category Thumbnail</label>
  <div class="input-group">
    <div class="custom-file">
      <input type="file" class="form-control" id="photo" name="photo" accept="image/*"
        onchange="changeTitleOfImageUploader(this)">
      <label class="custom-file-label" for="photo">Choose thumbnail</label>
    </div>
  </div>
  @error('photo')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>
