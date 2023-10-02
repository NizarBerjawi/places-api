<button 
    @class($classes ?? []) 
    @isset($type ) type={{ $type }} @endisset 
    onclick="this.form.submit(); this.disabled=true;"
    @disabled($disabled ?? false)
>
    {{ $label ?? '' }}
</button>

