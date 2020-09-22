@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
    # {{ $greeting }}
@else
    @if ($level === 'error')
        # @lang('lang.Whoops!')
    @elseif($level === 'success')
        # @lang('lang.Congratulations!')
    @else
        # @lang('lang.Hello!')
    @endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('lang.Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "اگر در فشردن دکمه  \":actionText\" به مشکل برخوردید, لینک زیر را در مرورگر خود\n".
    'وارد نمایید: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endslot
@endisset
@endcomponent
