@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Are you sure you want to delete "{{ $token->name }}"?
    </h1>

    <article class="message is-danger">
        <div class="message-body">
            You are permenantly deleting this API access token. <span class="has-text-weight-bold">This action is
                irreversible.</span>
        </div>
    </article>

    <form method="post" action="{{ route('admin.tokens.destroy', $token->id) }}">
        @csrf
        @method('DELETE')

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-large is-responsive">Cancel</a>
                </p>
                <p class="control">
                    <button class="button is-danger is-large is-responsive" type="submit">Delete token</button>
                </p>
            </div>
        </div>
    </form>
@endsection
