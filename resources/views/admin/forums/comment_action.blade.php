<div class='btn-group'>
    <form action="{{ route('admin.forum_comments.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-default btn-xs"  onclick="return confirm('are you sure to delete ?')"><i class="fa fa-trash"></i></button>
    </form>
</div>

