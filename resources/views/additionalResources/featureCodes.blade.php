@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <article class="panel pb-4">
                <p class="panel-heading">Feature Codes</p>
                <p class="panel-tabs">
                    <a href={{ route('featureCodes') }}
                        class="{{ !request()->has('filter') ? 'is-active' : '' }}">All</a>
                    @foreach ($featureClasses as $featureClass)
                        <a href="{{ route('featureCodes') . '?filter[featureClassCode]=' . $featureClass->code }}"
                            class="{{ $featureClass->code === \Illuminate\Support\Arr::get(request()->get('filter'), 'featureClassCode') ? 'is-active' : '' }}"">
                                            {{ $featureClass->code }}
                                </a>
                              @endforeach
                </p>

                <table class='table is-fullwidth'>
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
                {{ $featureCodes->links('partials.pagination') }}
            </article>
        </div>
    </section>

@endsection
