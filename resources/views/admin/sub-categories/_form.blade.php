<div class="form-group mb-3">
  <label for="name">Sub-Category Title<span class="required">*</span></label>
  <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required="">
  @error('name')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>


<div class="form-group mb-3">
  <label for="description">Sub-Category Description</label>
  <textarea class="form-control" name="description" id="description" required="" rows="6">{{ $category->description }} </textarea>
  @error('description')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>

<div class="form-group mb-3">
    <label for="description">Category</label>
    <select name="category_id" id="inputPriority" class="form-control valid" aria-invalid="false">
        <option value="">--Select Category--</option>
        @if (count($categories) > 0)
            @foreach ($categories as $item)
                <option value="{{ $item->id }}" @if ($item->id == $category->parent_id) selected @endif>
                    {{ $item->name }}
                </option>
            @endforeach
        @endif
    </select>
    @error('category_type')
        <small class="text-danger col-md-12">{{ $message }}</small>
    @enderror
</div>

<div class="form-group mb-3" id="thumbnail-picker-area">
  <label>Sub-Category Thumbnail</label>
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
