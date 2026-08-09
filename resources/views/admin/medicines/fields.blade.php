<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="">Medicine Name<span class="text-danger">*</span></label>
   <input type="text" name="name" value="{{ $medicine->name ?? old('name') }}" class="form-control" id="name" required>
    @error('name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Uses Field -->
<div class="form-group col-sm-12">
   <label for="">Uses<span class="text-danger">*</span></label>
   <textarea name="uses" class="form-control tinymce-editor" id="uses" cols="30" rows="10">{{ $medicine->uses ?? old('uses') }}</textarea>
    @error('uses')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
   <label for="">Side Effects<span class="text-danger">*</span></label>
   <textarea name="side_effects" class="form-control tinymce-editor" id="side_effects" cols="30" rows="10">{{ $medicine->side_effects ?? old('side_effects')}}</textarea>
    @error('side_effects')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Uses Field -->
<div class="form-group col-sm-12">
   <label for="">Precautions<span class="text-danger">*</span></label>
   <textarea name="precautions" class="form-control tinymce-editor" id="precautions" cols="30" rows="10">{{ $medicine->precautions ?? old('precautions') }}</textarea>
    @error('precautions')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
   <label for="">Interactions<span class="text-danger">*</span></label>
   <textarea name="interactions" class="form-control tinymce-editor" id="interactions" cols="30" rows="10">{{ $medicine->interactions ??  old('interactions') }}</textarea>
    @error('interactions')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>


<div class="form-group col-sm-12">
   <label for="">Additional Information<span class="text-danger">*</span></label>
   <textarea name="additional_information" class="form-control tinymce-editor" id="additional_information" cols="30" rows="10">{{ $medicine->additional_information ?? old('additional_information')}}</textarea>
    @error('additional_information')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6" id="imageField">
    <label for="pdf">Pdf <span style="color: red;">*</span></label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="pdf/*" id="pdf"  name="pdf" type="file">
            <label for="pdf" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('pdf')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
@if (!empty($medicine->pdf_path))
<div class="form-group col-sm-6" >
    @if(is_file(public_path('storage/' . $medicine?->pdf_path)))
       <label for="">&nbsp;</label><br/>
       <a href="{{ url('storage/'. $medicine?->pdf_path) }}">View</a>
    @endif
</div>
@endif

<div class="form-group col-sm-6" id="imageField">
    <label for="pdf">Pdf 2 </label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="pdf/*" id="pdf2"  name="pdf2" type="file">
            <label for="pdf2" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('pdf2')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
@if (!empty($medicine->pdf_path2))
<div class="form-group col-sm-6" >
    @if(is_file(public_path('storage/' . $medicine?->pdf_path2)))
       <label for="">&nbsp;</label><br/>
       <a href="{{ url('storage/'. $medicine?->pdf_path2) }}">View</a>
    @endif
</div>
@endif

<div class="form-group col-sm-6" id="imageField">
    <label for="pdf">Pdf 3 </label>
    <div class="input-group">
        <div class="custom-file">
            <input class="custom-file-input" accept="pdf/*" id="pdf3"  name="pdf3" type="file">
            <label for="pdf3" class="custom-file-label">Choose file</label>
        </div>
    </div>
    @error('pdf3')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
@if (!empty($medicine->pdf_path3))
<div class="form-group col-sm-6" >
    @if(is_file(public_path('storage/' . $medicine?->pdf_path3)))
       <label for="">&nbsp;</label><br/>
       <a href="{{ url('storage/'. $medicine?->pdf_path3) }}">View</a>
    @endif
</div>
@endif
<div class="form-group col-sm-6">
    <label for=""> Status </label>
<select name="status" id="status" class="form-control" required>
    <option value="">Select Option</option>
    <option value="1" {{ old('status', $medicine->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
    <option value="0" {{ old('status', $medicine->status ?? '') == 0 ? 'selected' : '' }}>Disable</option>
</select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-12">
   <label for="">Video Iframe</label>
   <textarea name="video_path" class="form-control" id="video_path" cols="30" rows="10">{{ $medicine->video_path ?? old('video_path')}}</textarea>
    @error('video_path')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>




