@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Are you sure you want to delete "{{ $token->name }}"?
    </h1>

    <article class="message is-danger">
        <div class="message-body">
            {!! __('tokens.delete') !!}
        </div>
    </article>

    <form method="post" action="{{ route('admin.tokens.destroy', $token->uuid) }}">
        @csrf
        @method('DELETE')

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Cancel</a>
                </p>
                <p class="control">
                    @include('component.button', [
                        'classes' => ['button', 'is-danger', 'is-medium', 'is-responsive'],
                        'type' => 'submit',
                        'label' => 'Delete token'
                    ])
                </p>
            </div>
        </div>
    </form>
@endsection
