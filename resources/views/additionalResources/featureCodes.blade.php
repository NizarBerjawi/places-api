@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <p class="title">Feature Codes</p>

                        <div class="tabs is-large is-centered">
                            <ul>
                                <li @class(['is-active' => !request()->has('filter')])>
                                    <a href={{ route('featureCodes') }}>All</a>
                                </li>

                                @foreach ($featureClasses as $featureClass)
                                    <li @class([
                                        'is-active' =>
                                            $featureClass->code === request()->input('filter.featureClassCode'),
                                    ])>
                                        <a
                                            href="{{ route('featureCodes', ['filter' => ['featureClassCode' => $featureClass->code]]) }}">
                                            {{ $featureClass->code }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="table-container">
                            <table class='table is-striped'>
                                <thead>
                                    <tr
                                        class="is-selected has-text-centered has-text-weight-bold has-background-primary">
                                        <td colspan="3">
                                            {{ $selectedFeatureClass ?? 'ALL' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Code</th>
                                        <th>Short Description</th>
                                        <th>Full Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($featureCodes as $featureCode)
                                        <tr>
                                            <td>{{ $featureCode->code }}</td>
                                            <td>{{ $featureCode->short_description }}</td>
                                            <td>{{ $featureCode->full_description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $featureCodes->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
