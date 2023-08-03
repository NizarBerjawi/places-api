@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
            Delete Account
        </h1>

        <article class="message is-danger">
            <div class="message-body">
                Once you delete your account, there is no going back. <span class="has-text-weight-bold">Please be
                    certain.</span>
            </div>
        </article>

        <form action="{{ route('admin.account.delete', $user->id) }}" method="post">
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
