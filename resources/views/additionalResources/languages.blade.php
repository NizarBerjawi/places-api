@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <article class="panel pb-4">
                <p class="panel-heading">Languages</p>
                
                <table class='table is-fullwidth'>
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
                {{ $languages->links('partials.pagination') }}
            </article>
        </div>
    </section>
@endsection
