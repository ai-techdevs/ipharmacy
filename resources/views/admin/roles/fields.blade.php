<!-- Name Field -->
<div class="form-group col-sm-6">
    <label for="">Role Name </label>
    <input type="text" id="name" name="name" class="form-control" required value="{{ $role->name ?? ''}}">
    @error('name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <label for="">Display Name </label>
    <input type="text" id="display_name" name="display_name" class="form-control" required value="{{ $role->display_name ?? ''}}">
    @error('display_name')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div>


<!-- Status Field -->
{{-- <div class="form-group col-sm-6">
    <label for=""> Status </label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Option</option>
        <option value="1" @if(isset($delivery) && $delivery->status == 1) selected  @endif>Active</option>
        <option value="0" @if(isset($delivery) && $delivery->status == 0) selected  @endif>Disbale</option>
    </select>
    @error('status')
        <span class="text text-danger">{{ $message }}</span>
    @enderror
</div> --}}


<div class="card-body">
    <h2 for="status">Permissions</h2>
    <hr>
    <div class="row">
        @foreach($menus as $menu)
        <div class="form-group col-sm-4">
            <ul>
                <li>
                    <input type="checkbox" id={{$menu->name}} class="permission-group" onclick=getId(this) value="{{$menu->name}}">
                    <label for="menus" ><strong>{{$menu->view_name}}</strong></label>
                    @foreach($menu->permissions as $permission)
                        <ul>
                            <li>
                                <input type="checkbox"  name='permissions[]' class="{{$menu->name}}_permission" value={{$permission->id}} <?php if(in_array($permission->id,$roleHasPermission)){ echo 'checked';} ?>>
                                <label for="permission-6">{{$permission->display_name}}</label>
                            </li>
                        </ul>
                    @endforeach
                </li>
            </ul>
        </div>
    @endforeach
    </div>

</div>

<script>
    let ele;
    function getId(elem)
    {
        //console.log('hello');
        ele = $(elem).attr("id");
        if ($(elem).is(':checked'))
        {
        $(`.${ele}_permission`).each(function (){
            $(this).prop("checked", true);
        });
        //console.log($(elem).attr("id"));
        }
        else
        {
            $(`.${ele}_permission`).each(function (){
                $(this).prop("checked", false);
            });
            //console.log($(elem).attr("id"));
        }
    };
</script>
