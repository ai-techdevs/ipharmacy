
<div class="form-group col-sm-12">
    <label for="">Page Name<span class="text-danger">*</span></label>
   <input type="text" name="page_name" value="{{ $page->page_name ?? old('page_name')}}" class="form-control" id="page_name" required>
    @error('page_name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for="">Section Name</label>
   <input type="text" name="section_name" value="{{ $page->section_name ?? old('section_name')}}" class="form-control" id="section_name" >
    @error('section_name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for="">Section Title</label>
   <input type="text" name="section_title" value="{{ $page->section_title ??old('section_title')}}" class="form-control" id="section_title" >
    @error('section_title')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for=""> Section Text</label>
   <textarea name="section_text"  class="form-control tinymce-editor" id="description">{{ $page->section_text ??  old('section_text') }}</textarea>
    @error('section_text')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for=""> Description</label>
   <textarea name="description"  class="form-control tinymce-editor" id="description">{{ $page->description ??  old('description') }}</textarea>
    @error('description')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6" id="imageField">
    <label for="image_path">Image (600 X 600) </label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="image/*" id="image"  name="image" type="file">
            <label for="image" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('image')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

@if (!empty($page->image))
<div class="form-group col-sm-6" id="imageField">
    @if(is_file(public_path('storage/' . $page?->image)))
       <img id="image{{ $page?->id }}" src="{{ url('storage/'. $page?->image) }}" alt="" height="80" width="90">
    @endif
</div>
@endif
<!-- Status Field -->

<div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($page) && $page->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($page) && $page->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
