
<div class="form-group col-sm-6">
    <label for="">Name<span class="text-danger">*</span></label>
   <input type="text" name="name" value="{{ $partner->name ?? old('name') }}" class="form-control" id="name" required>
    @error('name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>


<div class="form-group col-sm-6" id="imageField">
    <label for="pdf">Image (179 X 50) <span style="color: red;">*</span></label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="image/*" id="image"  name="image" type="file">
            <label for="pdf" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('image')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

@if (!empty($partner->path))
<div class="form-group col-sm-6" >
    @if(is_file(public_path('storage/' . $partner?->path)))
       <label for="">&nbsp;</label><br/>
       <a href="{{ url('storage/'. $partner?->path) }}">View</a>
    @endif
</div>
@endif


