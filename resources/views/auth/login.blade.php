@extends('layouts.auth')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <section class="section">
                    <div class="content">
                        <div class="columns">
                            <div class="column is-6 is-offset-3">
                                <h1 class="is-size-1">Welcome Back!</h1>
                                <p class="is-size-4">New to Places API? <a href="{{ route('register') }}">Create an
                                        account</a></p>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input @class(['input', 'is-danger' => $errors->has('email'), 'is-large']) type="email" name="email"
                                                placeholder="e.g. alex@example.com" value={{ old('email') }}>
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                                    </div>

                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input @class(['input', 'is-danger' => $errors->has('email'), 'is-large']) type="password" name="password"
                                                placeholder="********">
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                                    </div>

                                    <div class="field">
                                        <label class="checkbox">
                                            <input class="mr-2 has-text-link" type="checkbox">Remember me
                                        </label>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end is-align-items-center">

                                        <div class="m-2 is-size-5">
                                            <a href="{{ route('password.request') }}">Forgot password?</a>
                                        </div>

                                        <div class="field is-grouped">
                                            <p class="control">
                                                <a href="{{ route('home') }}" class="button is-large">Back</a>
                                            </p>
                                            <p class="control">
                                                <button class="button is-primary is-large">Log in</button>
                                            </p>
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
