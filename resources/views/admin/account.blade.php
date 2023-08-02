@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
            Are you sure you want to delete your account?
        </h1>

        @if (!session()->has('auth.password_confirmed_at'))
            <article class="message is-danger">
                <div class="message-body">
                    Once you delete your account, there is no going back. <span class="has-text-weight-bold">Please be
                        certain.</span>
                </div>
            </article>
        @else
            <article class="message is-success">
                <div class="message-body">
                    Start configuring two-factor authentication.
                </div>
            </article>
        @endif

        <form action="{{ route('account.delete') }}" method="post">
            @csrf
            @method('delete')
            <div class="is-flex is-justify-content-flex-end">
                <button class="button is-danger is-medium is-responsive">
                    Delete account
                </button>
            </div>
        </form>
    </section>
@endsection
