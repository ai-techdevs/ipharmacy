
<div class="form-group col-sm-12">
    <label for="">Title<span class="text-danger">*</span></label>
   <input type="text" name="title" value="{{ $cdc->title ?? old('title') }}" class="form-control" id="question" required>
    @error('title')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for=""> Author<span class="text-danger">*</span></label>
   <input type="text" name="author" value="{{ $cdc->author ?? old('author') }}" class="form-control" id="author" required>
    @error('author')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for=""> Description<span class="text-danger">*</span></label>
   <textarea name="description"  class="form-control tinymce-editor" id="description">{{ $cdc->description ??  old('description') }}</textarea>
    @error('description')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Status Field -->

<div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($cdc) && $cdc->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($cdc) && $cdc->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="related_blogs_ids">Related Blogs</label>
    <select name="related_blogs_ids[]" id="related_blogs_ids" class="form-control" multiple>
        @foreach($relatedBlogs as $blog)
            <option value="{{ $blog->id }}"
                @if(in_array($blog->id, $selectedRelated)) selected @endif>
                {{ $blog->title }}
            </option>
        @endforeach
    </select>
    @error('related_blogs_ids')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6" id="imageField">
    <label for="image_path">Image (600 X 600) <span style="color: red;">*</span></label>
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

@if (!empty($cdc->image))
<div class="form-group col-sm-6" id="imageField">
    @if(is_file(public_path('storage/' . $cdc?->image)))
       <img id="image{{ $cdc?->id }}" src="{{ url('storage/'. $cdc?->image) }}" alt="" height="80" width="90">
    @endif
</div>
@endif
