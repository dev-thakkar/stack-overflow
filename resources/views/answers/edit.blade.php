@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h1>Ask a Question</h1></div>
                    <div class="card-body">
                        <form action="{{route('questions.answers.update', [$question->id, $answer->id])}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" id="body" name="body" value="{{ old('body', $answer->body) }}">
                                <trix-editor input="body"></trix-editor>
                                @error('body')
                                <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success">Update a question</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
@endsection