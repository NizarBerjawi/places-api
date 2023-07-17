@extends('layouts.base')

@section('content')
<div class="container">
    <section class="section">
        <div class="content">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    <form class="box" method="POST" action="/register">
                        @csrf

                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('name')
                                ]) type="text" name="name" placeholder="e.g. John Smith" value="{{ old('name') }}">
                            </div>
                            <p class="help is-danger">{{ $errors->first('name') }}</p>

                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('email')
                                ]) type="email" name="email" placeholder="e.g. john@example.com" value="{{ old('email') }}">
                            </div>
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('password')
                                ]) type="password" name="password" placeholder="********">
                            </div>
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                        </div>


                        <div class="field">
                            <label class="label">Confirm Password</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('password_confirmation')
                                ]) type="password" name="password_confirmation" placeholder="********">
                            </div>
                            <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                        </div>

                        <div class="is-flex is-justify-content-flex-end">
                            <div class="m-2 has-text-link"><a href="/login">Already registered?</a></div>

                            <button class="button is-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection