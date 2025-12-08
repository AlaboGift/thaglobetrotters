<h5>Filter</h5>
<hr />
<div class="form-group">
  <label>Status</label>
  <select name="status" class="form-control">
    <option value="">Select Status</option>
    @foreach (\App\Enums\Status::getValues() as $option)
      <option value="{{ $option }}">{{ $option }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label>Start Date</label>
  <input class="form-control" name="startDate" type="date">
</div>
<div class="form-group">
  <label>End Date</label>
  <input class="form-control" name="endDate" type="date">
</div>
<div class="form-group mt-3">
  <button class="btn btn-primary" type="submit">Submit</button>
</div>
