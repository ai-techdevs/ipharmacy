<div class='btn-group'>
    <!-- Edit/Review -->
    <a href="{{ route('admin.temp-cdc-posts.edit', $id) }}" class='btn btn-default btn-xs' title="Review & Edit">
        <i class="fas fa-edit"></i>
    </a>
    
    <!-- Quick Toggle Approval -->
    <form action="{{ route('admin.temp-cdc-posts.toggle-status', $id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-{{ $status == 1 ? 'warning' : 'success' }} btn-xs" title="{{ $status == 1 ? 'Disable / Reject' : 'Approve & Publish' }}">
            <i class="fas fa-{{ $status == 1 ? 'ban' : 'upload' }}"></i>
        </button>
    </form>

    <!-- Delete -->
    <form action="{{ route('admin.temp-cdc-posts.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this temporary post?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-xs" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
