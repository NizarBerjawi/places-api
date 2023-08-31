@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Are you sure you want to regenerate the "{{ $token->name }}" token?
    </h1>

    <article class="message is-warning">
        <div class="message-body">
            {!! __('tokens.regenerate') !!}
        </div>
    </article>

    <form method="post" action="{{ route('admin.tokens.update', ['uuid' => $token->uuid, 'action' => $action]) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Expiry date</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('expires_at'),
                    'is-medium',
                ]) min="{{ \Illuminate\Support\Carbon::tomorrow()->format('Y-m-d') }}"
                    type="date" name="expires_at" value="{{ old('expires_at') }}">
            </div>
            <p class="help">{{ __('tokens.expiry') }}</p>
            <p class="help is-danger">{{ $errors->first('expires_at') }}</p>
        </div>
        
        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Cancel</a>
                </p>
                <p class="control">
                    <button class="button is-warning is-medium is-responsive" type="submit">Regenerate token</button>
                </p>
            </div>
        </div>
    </form>
@endsection
