@extends('layouts.auth')

@section('content')
<section class="hero is-fullheight-with-navbar">
    <div class="hero-body">
        <div class="container">
            <section class="section">
                <div class="content">
                    <div class="columns">
                        <div class="column is-6 is-offset-3">
                            <h1 class="is-size-1">Reset your password</h1>
                            <form method="POST" action="{{ route('password.update', $request->token) }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ request()->route('token')}}">
                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input @class([ 
                                            'input', 
                                            'is-danger'=> $errors->has('email'),
                                            'is-large',
                                        ]) type="email" name="email" placeholder="e.g. alex@example.com" value={{ request()->get('email') }} disabled>
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                </div>

                                <div class="field">
                                    <label class="label">Password</label>
                                    <div class="control">
                                        <input @class([
                                            'input', 
                                            'is-danger' => $errors->has('password'), 
                                            'is-large'
                                        ]) type="password" name="password" placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                </div>


                                <div class="field">
                                    <label class="label">Confirm Password</label>
                                    <div class="control">
                                        <input @class([
                                            'input', 
                                            'is-danger' => $errors->has('password_confirmation'),
                                            'is-large'
                                        ]) type="password" name="password_confirmation" placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                </div>


                                <div class="is-flex is-justify-content-flex-end">
                                    <div class="field is-grouped">
                                        <p class="control">
                                            <a href="{{ route('home') }}" class="button is-large">Back</a>
                                        </p>
                                        <p class="control">
                                            <button class="button is-primary is-large">Reset password</button>
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