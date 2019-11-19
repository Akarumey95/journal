@extends('layouts.app')

@section('content')
    <a href="/" class="home__link">Home</a>

    <iframe style="width:100%; height: calc(100vh - 10px)" src="{{asset($file_path . $data->journal_path)}}"></iframe>
@endsection