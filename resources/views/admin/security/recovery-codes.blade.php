@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Recovery Codes
    </h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">Keep your recovery codes safe.</span> These codes are
            the last resort for accessing your account in case you lose your password and second
            factors.
        </div>
    </article>

    <div class="has-text-centered m-4">
        @foreach (request()->user()->recoveryCodes() as $code)
            <pre class='is-size-5 m-0 p-2'>{{ $code }}</pre>
        @endforeach
    </div>

    <form method="post" action="{{ route('two-factor.recovery-codes') }}">
        @csrf

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <div class="control">
                    <a href="{{ route('admin.security.index') }}" class="button is-medium is-responsive">Back</a>
                </div>
                <div class="control">
                    @include('component.button', [
                        'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                        'type' => 'submit',
                        'label' => 'Regenerate codes'
                    ])
                </div>
            </div>
        </div>
    </form>
@endsection
