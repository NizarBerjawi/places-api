@extends('layouts.base')

@section('content')
<div class="container">
    <section class="section">
        <div class="content">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    <form class="box" method="POST" action="{{ route('password.update', $request->token) }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ request()->route('token')}}">
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input @class([ 'input' , 'is-danger'=> $errors->has('email')
                                ]) type="email" name="email" placeholder="e.g. alex@example.com" value={{ old('email')
                                }}>
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
                            <button class="button is-primary">Reset password</button>
                        </div>
                       
                        @if (session('status'))
                        <article class="message is-success mt-2">
                            <div class="message-body">
                                {{ session('status') }}
                            </div>
                          </article>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection