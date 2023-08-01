@extends('layouts.auth')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <section class="section">
                    <div class="content">
                        <div class="columns">
                            <div class="column is-6 is-offset-3">
                                <h1 class="is-size-1 is-size-3-mobile">Two-factor authentication</h1>
                                <article class="message is-info">
                                    <div class="message-body">
                                        Open your two-factor authenticator (TOTP) app or browser extension to view your
                                        authentication code.
                                    </div>
                                </article>
                                <form method="post" action="{{ route('two-factor.login') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Authentication code</label>
                                        <div class="control">
                                            <input @class([
                                                'input',
                                                'is-danger' => $errors->has('code'),
                                                'is-medium',
                                                'has-text-centered',
                                            ]) type="text" name="code"
                                                placeholder="XXXXXX" maxlength="6" autofocus>
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('code') }}</p>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end">
                                        <div class="field is-grouped">

                                            <div class="control">
                                                <a href="{{ route('home') }}" class="button is-medium is-responsive">Back</a>
                                            </div>
                                            <div class="control">
                                                <button class="button is-primary is-medium is-responsive" type="submit">Verify</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
