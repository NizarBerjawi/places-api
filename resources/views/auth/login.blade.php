@extends('layouts.auth')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <section class="section">
                    <div class="content">
                        <div class="columns">
                            <div class="column is-6 is-offset-3">
                                <h1 class="is-size-1 is-size-3-mobile">Welcome Back!</h1>
                                <p class="is-size-4 is-size-6-mobile">New to Places API? <a
                                        href="{{ route('register') }}">Create an
                                        account</a></p>

                                <form method="post" action="{{ route('login') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input @class(['input', 'is-danger' => $errors->has('email'), 'is-medium']) type="email" name="email"
                                                placeholder="e.g. alex@example.com" value={{ old('email') }}>
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                                    </div>

                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input @class([
                                                'input',
                                                'is-danger' => $errors->has('email'),
                                                'is-medium',
                                                'is-small-mobile',
                                            ]) type="password" name="password"
                                                placeholder="********">
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                                    </div>

                                    <div class="field">
                                        <label class="checkbox">
                                            <input class="mr-2 has-text-link" type="checkbox" name="remember"
                                                value="true">Remember me
                                        </label>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end is-align-items-center">

                                        <div class="m-2 is-size-5 is-size-6-mobile">
                                            <a href="{{ route('password.request') }}">Forgot password?</a>
                                        </div>

                                        <div class="field is-grouped">
                                            <p class="control">
                                                <a href="{{ route('home') }}"
                                                    class="button is-medium is-responsive">Back</a>
                                            </p>
                                            <p class="control">
                                                @include('component.button', [
                                                    'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                                                    'type' => 'submit',
                                                    'label' => 'Log in'
                                                ])
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
