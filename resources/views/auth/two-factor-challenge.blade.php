@extends('layouts.auth')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <section class="section">
                    <div class="content">
                        <div class="columns">
                            <div class="column is-6 is-offset-3">
                                <h1 class="is-size-1">Two-factor authentication</h1>

                                <form method="POST" action="{{ route('two-factor.login') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Authentication code</label>
                                        <div class="control">
                                            <input @class([
                                                'input',
                                                'is-danger' => $errors->has('code'),
                                                'is-large',
                                                'has-text-centered',
                                            ]) type="text" name="code"
                                                placeholder="XXXXXX" maxlength="6">
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('code') }}</p>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end">
                                        <div class="field is-grouped">
                                            <p class="control">
                                                <button class="button is-primary is-large" type="submit">Verify</button>
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
