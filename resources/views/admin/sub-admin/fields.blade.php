<!-- Name Field -->
<div class="form-group col-sm-6">
    <label for="">User Name </label>
    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name ?? old('name') }}" @if(Request::is('*edit*')) readonly @endif>
    @error('name')
    <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for="">Email </label>
    <input type="text" id="email" name="email" class="form-control" value="{{ $user->email ?? old('email')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('email')
    <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-6">
    <label for="">Phone </label>
    <input type="text" id="mobile" name="mobile" class="form-control" value="{{ $user->mobile ?? old('mobile')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('mobile')
    <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>


<div class="form-group col-sm-6">
    <label for="">Password </label>
    <input type="password" id="password" name="password" class="form-control">
    @error('password')
    <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>


<div class="form-group col-sm-6">
    <label for=""> Role </label>
    <select name="role_id" id="role_id" class="form-control" onchange="loadRolePermissions(this.value)" @if(Request::is('*edit*')) readonly @endif>
        <option value="">Select Option</option>
        @foreach($roles->where('id', '!=', 3) as $role)
        @if(isset($user))

        <option value="{{$role->id}}" @if($user->role_id == $role->id) selected @endif>{{$role->display_name}}</option>
        @else

        <option value="{{$role->id}}">{{$role->display_name}}</option>
        @endif
        @endforeach
    </select>
    @error('role_id')
    <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control">
        <option value="">Select Option</option>
        <option value="1" @if(isset($user) && $user->status == 1) selected @endif>Active</option>
        <option value="0" @if(isset($user) && $user->status == 0) selected @endif>Disbale</option>
    </select>
    @error('status')
    <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
{{-- <div class="form-group col-sm-6" id="imageField">
    <label for="image">Image  </label>
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
<div class="form-group col-sm-6">
</div>
@if (!empty($user->image))
<div class="form-group col-sm-6">
    @if(is_file(public_path('storage/' . $user->image)))
    <img id="couponImage{{ $user->id }}" src="{{ url('storage/'. $user->image) }}" alt="Coupon Image" height="80" width="90" style="object-fit:cover; border-radius:6px;">
    @endif
</div>
@endif --}}
