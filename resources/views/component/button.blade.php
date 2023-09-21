<button @class($classes ?? []) @isset($type ) type={{ $type }} @endisset onClick="this.form.submit(); this.disabled=true;">{{ $label ?? '' }}</button>
