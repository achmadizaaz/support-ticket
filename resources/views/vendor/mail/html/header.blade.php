@props(['url'])
@php
    $option = \App\Models\Option::where('name','sidebar-icon')->first();
@endphp
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">

@elseif($option)
<img src="{{ asset($option->value ? 'storage/'. $option->value : 'assets/images/laravel.png') }}" alt="{{ $slot }}" height="24"> {{ $slot }}
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
