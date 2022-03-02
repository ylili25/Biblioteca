@extends('layouts.app')

@section('content')
<div class="container">
    <form-editoriales :editorial_id="{{ $id }}" />
</div>
@endsection
