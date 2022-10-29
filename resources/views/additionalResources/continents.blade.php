@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                            <p class="title">Continents</p>

                            <div class="table-container">
                                <table class='table is-striped'>
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($continents as $continent)
                                            <tr>
                                                <td>{{ $continent->code }}</td>
                                                <td>{{ $continent->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $continents->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
