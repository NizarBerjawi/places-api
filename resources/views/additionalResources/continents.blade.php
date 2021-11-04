@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <article class="panel pb-4">
                <p class="panel-heading">Continents</p>
                
                <table class='table is-fullwidth'>
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
                {{ $continents->links('partials.pagination') }}
            </article>

        </div>
    </section>
@endsection
