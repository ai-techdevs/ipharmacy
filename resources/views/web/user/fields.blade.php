<!-- Name Field -->
<div class="form-group col-sm-6">
    <label for="">User Name </label>
    <input type="text" id="name" name="name" class="form-control" required value="{{ $user->name ?? old('name') }}">
    @error('name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for="">Email </label>
    <input type="text" id="email" name="email" class="form-control" required value="{{ $user->email ?? old('email')}}">
    @error('email')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-6">
    <label for="">Password </label>
    <input type="password" id="password" name="password" class="form-control" value="{{  old('email') }}">
    @error('password')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-6">
    <label for=""> Role </label>
    <select name="role_id" id="role_id" class="form-control" required onchange="loadRolePermissions(this.value)" @if(isset($user)) readonly @endif>
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
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($user) && $user->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($user) && $user->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-6" @if(isset($user) && !empty($user->role_id==4)) style="display: block;" @else style="display: none;" @endif id="warehouse-field">
    <label for=""> Warehouse / Godown </label>
    <select name="warehouse_id" id="warehouse_id" class="form-control" >
        <option value="">Select Option</option>
        @foreach($godowns as $godown)
        @if(isset($user))

        <option value="{{$godown->id}}" @if($user->warehouse_id == $godown->id) selected  @endif>{{$godown->name}}</option>
        @else

        <option value="{{$godown->id}}" >{{$godown->name}}</option>
        @endif
        @endforeach
    </select>
    @error('warehouse_id')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>












