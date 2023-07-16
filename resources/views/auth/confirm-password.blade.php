@extends('layouts.base')

@section('content')
<div class="container">
    <section class="section">
        <div class="content">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    <article class="message is-info">
                        <div class="message-body">
                            To verify that this is you, we need you to provide your old password.
                        </div>
                    </article>

                    <form class="box" method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="field">
                            <label class="label">Old password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" placeholder="********">
                            </div>
                        </div>

                        <div class="is-flex is-justify-content-flex-end">
                            <button class="button is-primary" type="submit">Confirm password</button>
                        </div>

                        @if ($errors->any())
                        <div class="notification is-danger is-light mt-2">
                            {{ $errors->first() }}
                        </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection