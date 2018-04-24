@extends('common.layout.layout')

@section('title')
    {!! config('app.name') !!}
@endsection

@section('styles')
@endsection

@section('body')
    <input type="hidden" id="app_config" value="{!! base64_encode(json_encode(config('vue'))) !!}"/>
    <div id="app"></div>
    <footer class="text-center blockquote-footer">
        <p>&copy; Company 2017</p>
    </footer>
@endsection

@section('scripts')
    <script src="{!! elixir('js/app.js') !!}"></script>
@endsection
