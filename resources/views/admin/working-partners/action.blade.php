<div class='btn-group'>
    <form action="{{ route('admin.working-partners.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-default btn-xs">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this banner?");
    }
</script>

