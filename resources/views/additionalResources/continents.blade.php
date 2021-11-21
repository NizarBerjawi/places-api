@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <article class="panel pb-4">
                            <p class="panel-heading">Continents</p>

                            <div class="table-container">
                                <table class='table'>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                    </tr>

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

                            {{ $continents->onEachSide(1)->links('partials.pagination') }}
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
