@props([
    'get' => null,
    'post' => null,
    'put' => null,
    'delete' => null,
    'patch' => null,
    'action',
])

<form action="{{ $action }}" {{ $get ? "method='get'" : "method='post'" }} {{ $attributes }}>
    @if (!$get)
        @csrf
    @endif
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
