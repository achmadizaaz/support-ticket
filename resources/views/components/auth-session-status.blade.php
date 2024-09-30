@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success text-success']) }}>
        {{ $status }}
    </div>
@endif
