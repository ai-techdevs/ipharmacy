<!-- Name Field -->
<div class="form-group col-sm-6">
    <label for="">User First Name </label>
    <input type="text" id="name" name="name" class="form-control"  value="{{ $user->name ?? old('name') }}" readonly>
    @error('name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">User Last Name </label>
    <input type="text" id="last_name" name="last_name" class="form-control"  value="{{ $user->last_name ?? old('last_name') }}" readonly>
    @error('last_name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for="">Email </label>
    <input type="text" id="email" name="email" class="form-control"  value="{{ $user->email ?? old('email')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('email')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Age Group </label>
    <input type="text" id="mobile" name="mobile" class="form-control"  value="{{ $user->mobile ?? old('mobile')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('mobile')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Phone </label>
    <input type="text" id="age_group" name="age_group" class="form-control"  value="{{ $user->age_group ?? old('age_group')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('age_group')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Gender </label>
    <input type="text" id="gender" name="gender" class="form-control"  value="{{ $user->gender ?? old('gender')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('gender')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-12">
    <label for="address1">Address1 </label>
    <textarea name="address1" 
              class="form-control" 
              id="address1" >{{ $coupon->address1 ?? old('address1') }}</textarea>
    @error('address1')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-12">
    <label for="address2">Address2 </label>
    <textarea name="address2" 
              class="form-control" 
              id="address2" >{{ $coupon->address2 ?? old('address2') }}</textarea>
    @error('address2')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">City </label>
    <input type="text" id="city" name="city" class="form-control"  value="{{ $user->city ?? old('city')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('city')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">State </label>
    <input type="text" id="state" name="state" class="form-control"  value="{{ $user->state ?? old('state')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('state')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">ZIP </label>
    <input type="text" id="zip" name="zip" class="form-control"  value="{{ $user->zip ?? old('zip')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('zip')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Password </label>
    <input type="password" id="password" name="password" class="form-control" >
    @error('password')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Existing Medical Conditions </label>
    <input type="text" id="existing_medical_conditions" name="existing_medical_conditions" class="form-control"  value="{{ $user->existing_medical_conditions ?? old('existing_medical_conditions')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('existing_medical_conditions')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Currently Taking Medications </label>
    <input type="text" id="currently_taking_medications" name="currently_taking_medications" class="form-control"  value="{{ $user->currently_taking_medications ?? old('currently_taking_medications')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('currently_taking_medications')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Known Allergies</label>
    <input type="text" id="known_allergies" name="known_allergies" class="form-control"  value="{{ $user->known_allergies ?? old('known_allergies')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('known_allergies')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for="">Previous Surgeries </label>
    <input type="text" id="previous_surgeries" name="previous_surgeries" class="form-control"  value="{{ $user->previous_surgeries ?? old('previous_surgeries')}}" @if(Request::is('*edit*')) readonly @endif>
    @error('previous_surgeries')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
{{-- 
<div class="form-group col-sm-6">
    <label for=""> Role </label>
    <select name="role_id" id="role_id" class="form-control"  onchange="loadRolePermissions(this.value)">
        <option value="">Select Option</option>
        @foreach($roles as $role)
        @if(isset($user))

        <option value="{{$role->id}}" @if($user->role_id == $role->id) selected  @endif>{{$role->display_name}}</option>
        @else

        <option value="{{$role->id}}" >{{$role->display_name}}</option>
        @endif
        @endforeach
    </select>
    @error('role_id')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div> --}}

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" >
        <option value="">Select Option</option>
        <option value="1" @if(isset($user) && $user->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($user) && $user->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6" id="imageField">
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
        <img id="couponImage{{ $user->id }}" 
             src="{{ url('storage/'. $user->image) }}" 
             alt="Coupon Image" height="80" width="90" 
             style="object-fit:cover; border-radius:6px;">
    @endif
</div>
@endif











