<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;

class VotesController extends Controller
{
    public function voteQuestion(Question $question, int $vote){
        $user = auth()->user();
        if($user->hasVoteForQuestion($question)){
            if(
                ($vote == 1 && !$user->hasQuestionUpVote($question))
                                    ||
                ($vote == -1 && !$user->hasQuestionDownVote($question))
            )
            {
                $question->updateVote($vote);
            }
        }
        else{
            $question->vote($vote);
        }
        return redirect()->back();
    }

    public function voteAnswer(Answer $answer, int $vote){
        $user = auth()->user();
        if($user->hasVoteForAnswer($answer)){
            if(
                ($vote == 1 && !$user->hasAnswerUpVote($answer))
                                    ||
                ($vote == -1 && !$user->hasAnswerDownVote($answer))
            )
            {
                $answer->updateVote($vote);
            }
        }
        else{
            $answer->vote($vote);
        }
        return redirect()->back();
    }
}
