@extends('layouts.base')

@section('menu')
    <aside class="menu">
        @foreach ($folders as $folder)
            <ul class="menu-list">
                <li>
                    <a href="?f={{ encrypt($folder) }}&token={{ config('app.key') }}">{{ $folder }}</a>

                    @if ($current_folder == $folder)
                        <ul>
                            @foreach ($folder_files as $file)
                                <li>
                                    <a href="?l={{ encrypt($file) }}&f={{ encrypt($folder) }}&token={{ config('app.key') }}"
                                        class="@if ($current_file == $file) is-active @endif">
                                        {{ $file }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </li>

                @foreach ($files as $file)
                    <li>
                        <a href="?l={{ encrypt($file) }}&token={{ config('app.key') }}" class="@if ($current_file == $file) is-active @endif">
                            {{ $file }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </aside>
@endsection




@section('content')



    <article class="panel pb-4">
        <div class="col-10 table-container">
            @if ($logs === null)
                <div>
                    Log file >50M, please download it.
                </div>
            @else
                <table class='table is-fullwidth'>
                    <thead>
                        <tr>
                            @if ($standardFormat)
                                <th>Level</th>
                                <th>Context</th>
                                <th>Date</th>
                            @else
                                <th>Line number</th>
                            @endif
                            <th>Content</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($logs as $key => $log)
                            <tr>
                                @if ($standardFormat)
                                    <td><span class="tag is-{{ $log['level_class'] }}">{{ $log['level'] }}</span></td>
                                    <td><span class="tag is-light">{{ $log['context'] }}</span></td>
                                    <td>{{ $log['date'] }}</td>
                                @endif


                                <td>
                                    {{ $log['text'] }}

                                    @if (isset($log['in_file']))
                                        <br />{{ $log['in_file'] }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif



            <div class="p-3">
                @if ($current_file)
                    <div class="buttons">
                        <a class="button is-info"
                            href="?dl={{ encrypt($current_file) }}{{ $current_folder ? '&f=' . encrypt($current_folder) : '' }}&token={{ config('app.key') }}">
                            Download file
                        </a>
                        -
                        <a id="delete-log" class="button is-danger"
                            href="?del={{ encrypt($current_file) }}{{ $current_folder ? '&f=' . encrypt($current_folder) : '' }}&token={{ config('app.key') }}">
                            Delete file
                        </a>
                        @if (count($files) > 1)
                            -
                            <a id="delete-all-log" class="button is-danger"
                                href="?delall=true{{ $current_folder ? '&f=' . encrypt($current_folder) : '' }}&token={{ config('app.key') }}">
                                Delete all files
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

    @endsection
