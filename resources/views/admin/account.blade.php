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
                                <input class="input" type="email" name="email" value={{ auth()->user()->email }}
                                disabled>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Current password</label>
                            <div class="control">
                                <input class="input" type="password" name="current_password" placeholder="********" autofocus>
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
                            <button class="button is-primary" href="{{ route('password.confirm') }}">Update
                                password</button>
                        </div>
                    </form>
                    @php echo json_encode($errors); @endphp
                    @if ($errors->any())
                    <div class="notification is-danger is-light">
                        {{ $errors->first() }}
                    </div>
                    @endif
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