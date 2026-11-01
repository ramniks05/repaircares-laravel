@props(['title', 'action' => null, 'actionLabel' => 'Add new'])

<div class="admin-page-header">
    <h2>{{ $title }}</h2>
    @if($action)
        <a href="{{ $action }}" class="btn">{{ $actionLabel }}</a>
    @endif
</div>
