@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <p class="title">Time Zones</p>

                        <div class="table-container">
                            <table class='table is-striped'>
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Time Zone</th>
                                        <th>GMT Offset</th>
                                    </tr>
                                </thead>

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

                        {{ $timeZones->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
