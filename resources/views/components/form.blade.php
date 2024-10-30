@props([
    'post' => null,
    'put' => null,
    'delete' => null,
    'patch' => null,
    'action',
])

<form action="{{ $action }}" method="post" {{ $attributes }}>
    @csrf
    @if ($put)
        @method('PUT')
    @endif
    @if ($delete)
        @method('DELETE')
    @endif
    @if ($patch)
        @method('PATCH')
    @endif
    {{ $slot }}
</form>
