@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <article class="panel pb-4">
                            <p class="panel-heading">Languages</p>

                            <div class="table-container">
                                <table class='table'>
                                    <tr>
                                        <th>Name</th>
                                        <th>ISO639-1</th>
                                        <th>ISO639-2</th>
                                        <th>ISO639-3</th>
                                    </tr>

                                    <tbody>
                                        @foreach ($languages as $language)
                                            <tr>
                                                <td>{{ $language->name }}</td>
                                                <td>{{ $language->iso639_1 }}</td>
                                                <td>{{ $language->iso639_2 }}</td>
                                                <td>{{ $language->iso639_3 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $languages->onEachSide(1)->links('partials.pagination') }}
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
