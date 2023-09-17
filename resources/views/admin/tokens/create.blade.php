@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Create Token
    </h1>

    @if ($errors->has('token_count'))
        <article class="message is-danger mt-4">
            <div class="message-body">
                {!! $errors->first('token_count') !!}
            </div>
        </article>
    @endif

    <form method="post" action="{{ route('admin.tokens.store') }}">
        @csrf
        <div class="block">
            <div class="field">
                <label class="label">Token name</label>
                <div class="control">
                    <input @class([
                        'input',
                        'is-danger' => $errors->has('token_name'),
                        'is-medium',
                    ]) type="text" name="token_name" placeholder="My token"
                        value="{{ old('token_name') }}" autofocus>
                </div>
                <p class="help is-danger">{{ $errors->first('token_name') }}</p>
            </div>

            <div class="field">
                <label class="label">Expiration date</label>

                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="product_id" @class([
                            'input',
                            'is-danger' => $errors->has('product_id'),
                            'is-medium',
                        ])>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                    {{ $product->name }} - ${{ $product->default_price->unit_amount / 100 }}</option>
                            @endforeach
                        </select>
                    </div>

                    <p class="help is-danger">{{ $errors->first('product_id') }}</p>
                </div>
            </div>
        </div>

        <div class="is-flex is-justify-content-flex-end is-align-items-center">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Cancel</a>
                </p>
                <p class="control">
                    <button class="button is-primary is-medium is-responsive" type="submit">Continue</button>
                </p>
            </div>
        </div>
    </form>
@endsection
