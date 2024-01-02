@if ($errors->any())
    <div {{ $attributes }}>
        <div style="font-weight: bold">{{ __('Ops! Algo salió mal.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm" style="color: #ff0000">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
