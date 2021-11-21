@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <article class="panel pb-4">
                            <p class="panel-heading">Time Zones</p>

                            <div class="table-container">
                                <table class='table'>
                                    <tr>
                                        <th>Code</th>
                                        <th>Time Zone</th>
                                        <th>GMT Offset</th>
                                    </tr>

                                    <tbody>
                                        @foreach ($timeZones as $timeZone)
                                            <tr>
                                                <td>{{ $timeZone->code }}</td>
                                                <td>{{ $timeZone->time_zone }}</td>
                                                <td>{{ $timeZone->gmt_offset }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $timeZones->onEachSide(1)->links('partials.pagination') }}
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
