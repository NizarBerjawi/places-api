@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Are you sure you want to regenerate "{{ $token->name }}"?
    </h1>

    <article class="message is-warning">
        <div class="message-body">
            If you've lost or forgotten this token, you can regenerate it, but be aware that any scripts or applications
            using this token will need to be updated.
            <span class="has-text-weight-bold">This action is irreversible.</span>
        </div>
    </article>

    <form method="post" action="{{ route('admin.tokens.update', ['id' => $token->id, 'action' => 'regenerate']) }}">
        @csrf
        @method('PUT')

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
