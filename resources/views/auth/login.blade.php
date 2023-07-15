@extends('layouts.base')

@section('content')
<div class="container">
    <section class="section">
        <div class="content">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    <form class="box" method="POST" action="/login">
                        @csrf

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" placeholder="e.g. alex@example.com">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" placeholder="********">
                            </div>
                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input class="mr-2" type="checkbox">Remember me
                            </label>
                        </div>

                        <div class="is-flex is-justify-content-flex-end">
                            <div class="m-2"><a href="">Forgot password?</a></div>

                            <button class="button is-primary">Log in</button>
                        </div>
                    </form>

                    @if ($errors->any())
                    <div class="notification is-danger is-light">
                        {{ $errors->first() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@endsection