@extends('layouts.auth')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <section class="section">
                    <div class="content">
                        <div class="columns">
                            <div class="column is-6 is-offset-3">
                                <h1 class="is-size-1 is-size-3-mobile">Forgot password?</h1>
                                <p class="is-size-4 is-size-6-mobile">New to Places API? <a
                                        href="{{ route('register') }}">Create an
                                        account</a></p>

                                @if (session('status'))
                                    <article class="message is-success mt-4">
                                        <div class="message-body">
                                            {{ session('status') }}
                                        </div>
                                    </article>
                                @endif

                                <form method="post" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input @class(['input', 'is-danger' => $errors->has('email'), 'is-medium']) type="email" name="email"
                                                placeholder="e.g. alex@example.com" value={{ old('email') }}>
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end">
                                        <div class="field is-grouped">
                                            <p class="control">
                                                <a href="{{ route('home') }}"
                                                    class="button is-medium is-responsive">Back</a>
                                            </p>
                                            <p class="control">
                                                @include('component.button', [
                                                    'classes' => [
                                                        'button',
                                                        'is-primary',
                                                        'is-medium',
                                                        'is-responsive',
                                                    ],
                                                    'type' => 'submit',
                                                    'label' => 'Send reset link',
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
