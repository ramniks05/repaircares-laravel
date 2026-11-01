@props(['editUrl' => null, 'deleteUrl' => null, 'viewUrl' => null, 'deleteConfirm' => 'Delete this record?'])

<div class="table-actions">
    @if($viewUrl)
        <a href="{{ $viewUrl }}" class="btn btn-sm btn-secondary">View</a>
    @endif
    @if($editUrl)
        <a href="{{ $editUrl }}" class="btn btn-sm">Edit</a>
    @endif
    @if($deleteUrl)
        <form method="POST" action="{{ $deleteUrl }}" onsubmit="return confirm(@json($deleteConfirm))">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
    @endif
</div>
