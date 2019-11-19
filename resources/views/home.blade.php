@extends('layouts.app')

@section('content')
    <div style="display: flex">
        @if(empty($data))
            <h1>No journals in database</h1>
        @else
            @foreach($data as $item)
                <div class="journal__item">
                    <div class="journal__item--poster" style="background-image: url('{{asset($file_path . $item->poster_path)}}')">
                        <div class="journal__item--overlay">
                            <div class="journal__item--action">
                                <a href="#" class="trigger__download" data-name="{{$item->name}}" data-path="{{asset($file_path . $item->journal_path) }}">
                                    Download
                                </a>
                                <a href="{{route('show', ['id' => $item->id])}}">
                                    Read
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection