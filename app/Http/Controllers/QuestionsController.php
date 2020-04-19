<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Http\Requests\UpdateRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function __construct()
    {
        //Authentication ka middleware likha hua hai jo validation ke kaam aayega. Request wali file se true directly return kar sakte if yaha ye likha hai to
        $this->middleware('auth')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //With isliye daala kyuki agar view side pe kar rahe the $question->owner to wo har time query maa raha tha
        //isiliye humne with relation maar diya to ek baar me sab leke aayega wo. Debug bar daala tha isko dekhne ke liye.
        $questions = Question::with('owner')->latest()->paginate(10);
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        //create
        auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        //session flash
        session()->flash('success', 'Question has been created Successfully!');
        return redirect(route('questions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views_count');
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if($this->authorize('update', $question)){
            return view('questions.edit',compact("question"));
        }
        abort(403, 'Access Denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Question $question)
    {
        if($this->authorize('update', $question)){
            $question->update([
                'title' => $request->title,
                'body' => $request->body
            ]);
            session()->flash('success', 'Updated question successfully!');
            return redirect(route('questions.index'));
        }
        abort(403, 'Access Denied');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if($this->authorize('delete', $question)){
            $question->delete();
            session()->flash('success', 'Deleted question successfully!');
            return redirect(route('questions.index'));
        }
        abort(403, 'Access Denied');
    }
}
