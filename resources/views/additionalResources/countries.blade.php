@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <p class="title">Countries</p>

                        <div class="table-container">
                            <table class='table is-striped'>
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>{{ $country->iso3166_alpha2 }}</td>
                                            <td>{{ $country->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $countries->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
