
<div class="form-group col-sm-12">
    <label for="">FAQ Question<span class="text-danger">*</span></label>
   <input type="text" name="question" value="{{ $faq->question ?? ''}}" class="form-control" id="question" required>
    @error('question')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for=""> Answer<span class="text-danger">*</span></label>
    <textarea name="answer"  class="form-control tinymce-editor" id="answer">{{ $faq->answer ??  old('answer') }}</textarea>
   {{-- <input type="text" name="answer" value="{{ $faq->answer ?? ''}}" class="form-control" id="answer" required> --}}
    @error('answer')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Status Field -->

<div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($faq) && $faq->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($faq) && $faq->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
