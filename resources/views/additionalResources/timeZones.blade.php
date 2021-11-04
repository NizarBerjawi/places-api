@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <article class="panel pb-4">
                <p class="panel-heading">Time Zones</p>
                
                <table class='table is-fullwidth'>
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
                {{ $timeZones->links('partials.pagination') }}
            </article>
        </div>
    </section>
@endsection
