@extends('layouts.auth')

@section('content')
<section class="hero is-fullheight-with-navbar">
    <div class="hero-body">
        <div class="container">
            <section class="section">
                <div class="content">
                    <div class="columns">
                        <div class="column is-6 is-offset-3">
                            <h1>Confirm your password</h1>
                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="field">
                                    <label class="label">Password</label>
                                    <div class="control">
                                        <input @class([ 
                                            "input" , 
                                            "is-danger" => $errors->has('password'),
                                            "is-large"
                                        ]) type="password" name="password" placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                </div>

                                <div class="is-flex is-justify-content-flex-end">
                                    <div class="field is-grouped">
                                        <p class="control">
                                            <a href="{{ route('admin.account') }}" class="button is-large">Back</a>
                                        </p>
                                        <p class="control">
                                            <button class="button is-primary is-large" type="submit">Confirm</button>
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