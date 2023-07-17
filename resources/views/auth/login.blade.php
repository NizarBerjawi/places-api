@extends('layouts.base')

@section('content')
<div class="container">
    <section class="section">
        <div class="content">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input @class([ 'input' , 'is-danger'=> $errors->has('email'), 'is-large' ])
                                type="email" name="email" placeholder="e.g. alex@example.com" value={{ old('email') }}>
                            </div>
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input @class([ 'input' , 'is-danger'=> $errors->has('email'), 'is-large' ])
                                type="password" name="password" placeholder="********">
                            </div>
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input class="mr-2 has-text-link" type="checkbox">Remember me
                            </label>
                        </div>

                        <div class="is-flex is-justify-content-flex-end">
                            <div class="m-2"><a href="{{ route('password.request') }}">Forgot password?</a></div>

                            <button class="button is-primary">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection