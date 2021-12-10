@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <article class="panel pb-4">
                            <p class="panel-heading">Feature Codes</p>
                            <p class="panel-tabs">
                                <a href={{ route('featureCodes') }} @class([
                                    'is-active' => !request()->has('filter'),
                                ])>
                                    All
                                </a>

                                @foreach ($featureClasses as $featureClass)
                                    <a href="{{ route('featureCodes', ['filter' => ['featureClassCode' => $featureClass->code]]) }}"
                                        @class([
                                            'is-active' =>
                                                $featureClass->code === request()->input('filter.featureClassCode'),
                                        ])>
                                        {{ $featureClass->code }}
                                    </a>
                                @endforeach
                            </p>

                            <div class="table-container">
                                <table class='table'>
                                    <tr class="is-selected has-text-centered has-text-weight-bold">
                                        <td colspan="3">
                                            {{ $selectedFeatureClass ?? 'ALL' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Code</th>
                                        <th>Short Description</th>
                                        <th>Full Description</th>
                                    </tr>

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
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
