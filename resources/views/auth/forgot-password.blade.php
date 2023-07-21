@extends('layouts.auth')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <section class="section">
                    <div class="content">
                        <div class="columns">
                            <div class="column is-6 is-offset-3">
                                <h1 class="is-size-1">Forgot password?</h1>
                                <p class="is-size-4">New to Places API? <a href="{{ route('register') }}">Create an
                                        account</a></p>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input @class(['input', 'is-danger' => $errors->has('email'), 'is-large']) type="email" name="email"
                                                placeholder="e.g. alex@example.com" value={{ old('email') }}>
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end">
                                        <div class="field is-grouped">
                                            <p class="control">
                                                <a href="{{ route('home') }}" class="button is-large">Back</a>
                                            </p>
                                            <p class="control">
                                                <button class="button is-primary is-large">Send reset link</button>
                                            </p>
                                        </div>
                                    </div>

                                    @if (session('status'))
                                        <article class="message is-success mt-4">
                                            <div class="message-body">
                                                {{ session('status') }}
                                            </div>
                                        </article>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
