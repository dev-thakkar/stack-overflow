<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Your answer</h3>
            </div>
            <div class="card-body">
                <form action="{{route('questions.answers.store',$question->id)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="body" name="body" value="{{ old('body') }}">
                        <trix-editor input="body"></trix-editor>
                        @error('body')
                        <div class="text-danger"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-success">Post your answer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>