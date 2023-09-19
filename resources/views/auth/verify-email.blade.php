@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
            Verify Account
        </h1>

        @if (session('status') === \Laravel\Fortify\Fortify::VERIFICATION_LINK_SENT)
            <article class="message is-success mt-4">
                <div class="message-body">
                    {!! __('auth.verification_resent') !!}
                </div>
            </article>
        @else
            <article class="message is-danger mt-4">
                <div class="message-body">
                    {!! __('auth.verification_sent') !!}
                </div>
            </article>
        @endif

        @if (session('status') !== \Laravel\Fortify\Fortify::VERIFICATION_LINK_SENT)
            <form method="post" action="{{ route('verification.send') }}">
                @csrf

                <div class="is-flex is-justify-content-flex-end">
                    <div class="field is-grouped">
                        <p class="control">
                            <button class="button is-primary is-medium is-responsive" onClick="this.form.submit(); this.disabled=true;">Resend email</button>
                        </p>
                    </div>
                </div>
            </form>
        @endif
    </section>
@endsection
