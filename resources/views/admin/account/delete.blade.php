@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Are you sure you want to delete your account?
    </h1>

    <article class="message is-danger">
        <div class="message-body">
            You are permenantly deleting your account. <span class="has-text-weight-bold">This action is
                irreversible.</span>
        </div>
    </article>

    <form action="{{ route('admin.account.delete', $user->id) }}" method="post">
        @csrf
        @method('DELETE')

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.account.index') }} class="button is-medium is-responsive">Cancel</a>
                </p>
                <p class="control">
                    @include('component.button', [
                        'classes' => ['button', 'is-danger', 'is-medium', 'is-responsive'],
                        'type' => 'submit',
                        'label' => 'Yes, delete my account'
                    ])
                </p>
            </div>
        </div>
    </form>
@endsection
