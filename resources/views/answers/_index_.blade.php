<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">
                    {{ $question->answers_count }} {{ Str::plural('Answer', $question->answer_count) }}
                </h3>
            </div>
            <div class="card-body">
                @foreach($question->answers as $answer)
                    <div class="d-flex">
                        <div>
                            @auth
                                <form action="{{ route('answers.vote', [$answer->id, 1]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn {{ auth()->user()->hasAnswerUpVote($answer) ? 'text-dark' : 'text-black-50' }}">
                                        <i class="fa fa-caret-up fa-3x "></i>
                                    </button>
                                </form>
                            @else
                                    <a href="{{ route('login') }}" class="d-block text-center text-black-50">
                                        <i class="fa fa-caret-up fa-3x "></i>
                                    </a>
                            @endauth
                            <h4 class="m-0 text-center text-dark">
                                {{ $answer->votes_count }}
                            </h4>
                                @auth
                                    <form action="{{ route('answers.vote', [$answer->id, -1]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn {{ auth()->user()->hasAnswerDownVote($answer) ? 'text-dark' : 'text-black-50' }}">
                                            <i class="fa fa-caret-down fa-3x "></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="d-block text-center text-black-50">
                                        <i class="fa fa-caret-down fa-3x "></i>
                                    </a>
                                @endauth
                            <div class="mt-2">
                                @can('markAsBest', $answer)
                                    <form action="{{ route('answers.bestAnswer', $answer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ $answer->best_answer_status }}">
                                            <i class="fa fa-check fa-2x "></i>
                                        </button>
                                    </form>
                                    @else
                                    @if($answer->is_best)
                                        <i class="fa fa-check fa-2x text-success"></i>

                                    @endif
                                @endcan
                            </div>
                        </div>
                        <div class="ml-5 flex-fill">
                            {!! $answer->body !!}

                            <div class="d-flex justify-content-between mt-2">
                                <div class="d-flex flex-row">
                                    @can('update', $answer)
                                        <div>
                                            <a href="{{route('questions.answers.edit', [$question->id, $answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                        </div>
                                    @endcan
                                    @can('delete', $answer)
                                        <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm mb-1"
                                                    onclick="return confirm('Are you sure you want to delete?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-muted flex-column">
                                        Asked : {{ $answer->created_date }}
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div>
                                            <img src="{{ $answer->author->avatar }}" alt="{{ $answer->author->name }}">
                                        </div>
                                        <div class="mt-2 ml-2">
                                            {{ $answer->author->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>