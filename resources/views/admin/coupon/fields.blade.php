<div class="form-group col-sm-6">
    <label for="discount">Discount <span class="text-danger">*</span></label>
    <input type="text" name="discount" 
           value="{{ $coupon->discount ?? old('discount') }}" 
           class="form-control" id="discount" required 
           placeholder="e.g. 30% Off">
    @error('discount')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-6">
    <label for="title">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" 
           value="{{ $coupon->title ?? old('title') }}" 
           class="form-control" id="title" required 
           placeholder="Coupon Title">
    @error('title')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-6">
    <label for="description">Description <span class="text-danger">*</span></label>
    <textarea name="description" 
              class="form-control" 
              id="description" required>{{ $coupon->description ?? old('description') }}</textarea>
    @error('description')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

{{-- <div class="form-group col-sm-6">
    <label for="button_text">Button Text</label>
    <input type="text" name="button_text" 
           value="{{ $coupon->button_text ?? old('button_text') }}" 
           class="form-control" id="button_text" 
           placeholder="e.g. Grab Now">
    @error('button_text')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-6">
    <label for="button_link">Button Link</label>
    <input type="url" name="button_link" 
           value="{{ $coupon->button_link ?? old('button_link') }}" 
           class="form-control" id="button_link" 
           placeholder="https://example.com">
    @error('button_link')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div> --}}

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for="status">Status</label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($coupon) && $coupon->status == 1) selected @endif>Active</option>
        <option value="0" @if(isset($coupon) && $coupon->status == 0) selected @endif>Disable</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Image Upload -->
<div class="form-group col-sm-6" id="imageField">
    <label for="image">Image  <span style="color: red;">*</span></label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="image/*" id="image" name="image" type="file">
            <label for="image" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('image')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>


<!-- Image Upload -->
<div class="form-group col-sm-6" id="imageField">
    <label for="image">Image 2  </label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="image/*" id="image2" name="image2" type="file">
            <label for="image2" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('image2')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

@if (!empty($coupon->image))
<div class="form-group col-sm-6">
    @if(is_file(public_path('storage/' . $coupon->image)))
        <img id="couponImage{{ $coupon->id }}" 
             src="{{ url('storage/'. $coupon->image) }}" 
             alt="Coupon Image" height="80" width="90" 
             style="object-fit:cover; border-radius:6px;">
    @endif
</div>
@endif
@if (!empty($coupon->image2))
<div class="form-group col-sm-6">
    @if(is_file(public_path('storage/' . $coupon->image2)))
        <img id="couponImage{{ $coupon->id }}" 
             src="{{ url('storage/'. $coupon->image2) }}" 
             alt="Coupon Image" height="80" width="90" 
             style="object-fit:cover; border-radius:6px;">
    @endif
</div>
@endif

