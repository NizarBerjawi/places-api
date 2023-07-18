@extends('layouts.admin')

@section('content')
<div class="container">
    <section class="section">
        <div class="columns">
            <div class="column is-6 is-offset-3">
                @include('partials.tabs')

                <section>
                    <h1 class="title">Change password</h1>

                    <form action="{{ route('user-password.update') }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('email')
                                ]) type="email" name="email" value={{ auth()->user()->email }}
                                disabled>
                            </div>
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                        </div>

                        <div class="field">
                            <label class="label">Current password</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('current_password')
                                ]) type="password" name="current_password" placeholder="********">
                            </div>
                            <p class="help is-danger">{{ $errors->first('current_password') }}</p>
                        </div>

                        <div class="field">
                            <label class="label">New password</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('password')
                                ]) type="password" name="password" placeholder="********">
                            </div>
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                        </div>

                        <div class="field">
                            <label class="label">Confirm new password</label>
                            <div class="control">
                                <input @class([
                                    'input', 
                                    'is-danger' => $errors->has('password_confirmation')
                                ]) type="password" name="password_confirmation"
                                    placeholder="********">
                            </div>
                            <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                        </div>

                        <div class="is-flex is-justify-content-flex-end">
                            <button class="button is-primary" href="{{ route('password.confirm') }}">Update
                                password</button>
                        </div>
                    </form>
                </section>

                <hr />

                {{-- <section>
                    <h1 class="title">Two-factor authentication</h1>
                    <form action="" method="post">
                        @csrf
                        <div class="field">
                            <label class="label">Old password</label>
                            <div class="control">
                                <input class="input" type="password" name="old_password" placeholder="********">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">New password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" placeholder="********">
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Confirm new password</label>
                            <div class="control">
                                <input class="input" type="password" name="password_confirmation"
                                    placeholder="********">
                            </div>
                        </div>


                        <div class="is-flex is-justify-content-flex-end">
                            <div class="m-2"><a href="">Forgot password?</a></div>

                            <button class="button is-primary">Update password</button>
                        </div>
                    </form>
                </section> --}}
            </div>
        </div>
    </section>
</div>
@endsection