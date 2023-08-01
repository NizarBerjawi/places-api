@extends('layouts.auth')

@section('content')
<section class="hero is-fullheight-with-navbar">
    <div class="hero-body">
        <div class="container">
            <section class="section">
                <div class="content">
                    <div class="columns">
                        <div class="column is-6 is-offset-3">
                            <h1 class="is-size-1 is-size-3-mobile">Create new account</h1>
                            <p class="is-size-4 is-size-6-mobile">Already registered? <a href="{{ route('login') }}">Login to your account</a></p>

                            <form method="post" action="/register">
                                @csrf

                                <div class="field">
                                    <label class="label">Name</label>
                                    <div class="control">
                                        <input @class([ 'input' , 'is-danger'=> $errors->has('name'),
                                        'is-medium'
                                        ]) type="text" name="name" placeholder="e.g. John Smith" value="{{ old('name') }}">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>

                                </div>

                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input @class([ 'input' , 'is-danger'=> $errors->has('email'),
                                        'is-medium'
                                        ]) type="email" name="email" placeholder="e.g. john@example.com" value="{{ old('email') }}">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                </div>

                                <div class="field">
                                    <label class="label">Password</label>
                                    <div class="control">
                                        <input @class([ 'input' , 'is-danger'=> $errors->has('password'),
                                        'is-medium'
                                        ]) type="password" name="password" placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                </div>


                                <div class="field">
                                    <label class="label">Confirm Password</label>
                                    <div class="control">
                                        <input @class([ 'input' , 'is-danger'=> $errors->has('password_confirmation'),
                                        'is-medium'
                                        ]) type="password" name="password_confirmation" placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                </div>

                                <div class="is-flex is-justify-content-flex-end is-align-items-center">
                                    <div class="field is-grouped">
                                        <p class="control">
                                            <a href="{{ route('home') }}" class="button is-medium is-responsive">Back</a>
                                        </p>
                                        <p class="control">
                                            <button class="button is-primary is-medium is-responsive">Register</button>
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