@extends('layouts.admin')

@section('content')
    <h1 class="title">API Tokens</h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">This is where you view all your API tokens.</span> These codes are
            the last resort for accessing your account in case you lose your password and second
            factors.
        </div>
    </article>

    {{-- @if (count(request()->user()->tokens) === 0)
        <p>You have not issued any API tokens yet.</p>
    @endif --}}

    <div class="mb-4">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Token</th>
                    <th>Created at</th>
                    <th>Expires at</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @if (count(request()->user()->tokens) === 0)
                    <tr>
                        <td colspan="5">You have not issued any tokens yet.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="is-flex is-justify-content-flex-end">
        <div class="field is-grouped">
            <div class="control">
                <a href="{{ route('admin.tokens.create')}}" class="button is-primary is-large is-responsive">Issue API Token</a>
            </div>
        </div>
    </div>
@endsection
