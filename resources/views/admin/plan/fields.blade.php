{{-- <div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($plan) && $plan->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($plan) && $plan->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
@enderror
</div> --}}
<div class="form-group col-sm-6">
    <label for="name">Plan Name</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group col-sm-6">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" value="{{ old('description') }}">
    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group col-sm-4">
    <label for="interval_unit">Interval Unit</label>
    <select name="interval_unit" class="form-control" required>
        <option value="">Select Unit</option>
        <option value="MONTH" {{ old('interval_unit')=='MONTH' ? 'selected' : '' }}>Month</option>
        <option value="YEAR" {{ old('interval_unit')=='YEAR' ? 'selected' : '' }}>Year</option>
    </select>
    @error('interval_unit') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group col-sm-4">
    <label for="interval_count">Interval Count</label>
    <input type="number" name="interval_count" class="form-control" value="{{ old('interval_count', 1) }}" required>
    @error('interval_count') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group col-sm-4">
    <label for="amount">Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group col-sm-4">
    <label for="currency">Currency</label>
    <input type="text" name="currency" class="form-control" value="{{ old('currency', 'USD') }}" required>
    @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group col-sm-4">
    <label for="status">Status</label>
    <select name="status" class="form-control" required>
        <option value="">Select Status</option>
        <option value="ACTIVE" {{ old('status')=='ACTIVE' ? 'selected' : '' }}>Active</option>
        <option value="INACTIVE" {{ old('status')=='INACTIVE' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
</div>
