<a href="{{ $url_show }}" class="btn btn-primary btn-sm">Show</a>
<form action="{{ $url_destroy }}" method="post" class="d-inline">
        @csrf
    @method('delete')
    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
</form>