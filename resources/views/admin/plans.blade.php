@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                @foreach ($products as $chunk)
                    <div class="columns">
                        @foreach ($chunk as $product)
                            <div class="column">
                                <div class="card"
                                    @if ($product->metadata?->most_popular === 'true') style="border: 2px solid #5e81ac;" @endif>
                                    <div class="card-content">
                                        <p class="title is-size-4-desktop is-size-4-tablet is-size-3-mobile">
                                            {{ $product->name }} 
                                            @if ($product->metadata?->most_popular === 'true')
                                                <span class="tag is-link">Most popular</span>
                                            @endif
                                        </p>
                                        <p class="subtitle has-text-weight-bold">
                                            ${{ $product->default_price?->unit_amount / 100 ?? 0 }} USD / month
                                        </p>
                                        <div class="content">
                                            @foreach ($product->features as $feature)
                                                <div class="icon-text m-1 ">
                                                    <span class="icon has-text-success">
                                                        <i class="icon is-small" data-feather="check-circle"></i>
                                                    </span>
                                                    <span class="is-size-6">{{ $feature->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <a
                                        href={{ route('admin.stripe.checkout', ['productId' => $product->id, 'priceId' => $product->default_price?->id]) }}>
                                        <footer class="card-footer has-background-primary is-clickable is-radiusless">
                                            <p class="card-footer-item has-text-weight-bold has-text-white">
                                                Subscribe
                                            </p>
                                        </footer>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
