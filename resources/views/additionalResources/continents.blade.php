@extends('layouts.base')

@section('content')
    <div class="content">
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
@endsection
