@extends('layouts.app')

@section('content')
<div class="container">
    <form-libros :libro_id="{{ $id }}" />
</div>
@endsection
