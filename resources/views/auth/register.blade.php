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
                                <input class="input" type="text" name="name" placeholder="e.g. John Smith">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" placeholder="e.g. john@example.com">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" placeholder="********">
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Confirm Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password_confirmation"
                                    placeholder="********">
                            </div>
                        </div>

                        <div class="is-flex is-justify-content-flex-end">
                            <div class="m-2"><a href="/login">Already registered?</a></div>

                            <button class="button is-primary">Register</button>
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