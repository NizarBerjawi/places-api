@extends('layouts.admin')

@section('content')
    <h1 class="title">Confirm Password</h1>

    <form method="post" action="{{ route('password.confirm') }}">
        @csrf

        @if ($intended === route('admin.account.confirm', ['id' => request()->user()->id, 'action' => 'delete']))
            <article class="message is-danger">
                <div class="message-body">
                    Once you confirm your password, you can <span class="has-text-weight-bold">delete your account
                        forever.</span>
                </div>
            </article>
        @endif

        @if ($intended === route('admin.security.index'))
            <article class="message is-info">
                <div class="message-body">
                    Once you confirm your password, you will be able to <span class="has-text-weight-bold">update your
                        two-factor authentication settings.</span>
                </div>
            </article>
        @endif

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->confirmPassword->has('password'),
                    'is-medium',
                ]) type="password" name="password" placeholder="********" autofocus>
            </div>
            <p class="help is-danger">{{ $errors->confirmPassword->first('password') }}</p>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    @if ($intended === route('admin.account.confirm', ['id' => request()->user()->id, 'action' => 'delete']))
                        <a href={{ route('admin.account.index') }} class="button is-medium is-responsive">Back</a>
                    @endif

                    @if ($intended === route('admin.security.index'))
                        <a href={{ route('admin.security.index') }} class="button is-medium is-responsive">Back</a>
                    @endif
                </p>
                <p class="control">
                    <button class="button is-primary is-medium is-responsive" type="submit">Confirm</button>
                </p>
            </div>
        </div>
    </form>
@endsection
