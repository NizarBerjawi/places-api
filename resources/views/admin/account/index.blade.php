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

        <div class="is-flex is-justify-content-flex-end">
            <a href="{{ route('admin.account.confirm', ['id' => $user->id, 'action' => 'delete']) }}" class="button is-danger is-medium is-responsive">
                Delete account
            </a>
        </div>
    </section>
@endsection
