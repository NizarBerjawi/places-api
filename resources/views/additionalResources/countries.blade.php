@extends('layouts.base')

@section('content')
    <div class="content">
        <article class="panel pb-4">
            <p class="panel-heading">Countries</p>

            <div class="table-container">
                <table class='table'>
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
            </div>
            
            {{ $countries->onEachSide(1)->links('partials.pagination') }}
        </article>
    </div>
@endsection
