@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <article class="panel pb-4">
                <p class="panel-heading">Countries</p>

                <table class='table is-fullwidth'>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                    </tr>

                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->iso3166_alpha2 }}</td>
                                <td>{{ $country->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $countries->links('partials.pagination') }}
            </article>

        </div>
    </section>

@endsection
