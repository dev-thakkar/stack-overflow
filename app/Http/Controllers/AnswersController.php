<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\Answers\CreateAnswerRequest;
use App\Http\Requests\Answers\UpdateAnswerRequest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param CreateAnswerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, CreateAnswerRequest $request)
    {
        $question->answers()->create([
            "body" =>$request->body,
            "user_id" => Auth::id(),
        ]);

        session()->flash('success','Your Answer has been added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer $answer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);
        return view('answers.edit',compact(['question','answer']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnswerRequest $request
     * @param Question $question
     * @param  \App\Answer $answer
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateAnswerRequest $request, Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);
        $answer->update([
            "body" => $request->body,
        ]);

        session()->flash('success','Your answers was updated successfully');
//        return view($question->slug);
        return redirect(route('questions.show',$question->slug));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        session()->flash('success', 'Answer deleted successfully!');

        return redirect()->back();
    }

    public function bestAnswer(Answer $answer){
        $answer->question->markAsBest($answer);
        return redirect()->back();
    }
}