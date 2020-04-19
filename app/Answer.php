<?php

namespace App;
use App\Question;

class Answer extends BaseModel
{
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function votes(){
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }

    public function vote(int $vote){
        $this->votes()->attach(auth()->id(),['vote'=>$vote]);
        if($vote < 0){
            $this->decrement('votes_count');
        }
        else{
            $this->increment('votes_count');
        }
    }

    public function updateVote($vote){
        $this->votes()->updateExistingPivot(auth()->id(), ['vote'=>$vote]);
        if($vote < 0){
            $this->decrement('votes_count');
            $this->decrement('votes_count');
        }
        else{
            $this->increment('votes_count');
            $this->increment('votes_count');
        }
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }


    public function getBestAnswerStatusAttribute(){
        if($this->id === $this->question->best_answer_id){
            return 'text-success';
        }
        return 'text-dark';
    }

    public function getIsBestAttribute(){
        return $this->id === $this->question->best_answer_id;
    }


    //Events
    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::created(function($answer){
            $answer->question->increment('answers_count');
        });
        static::deleted(function($answer){
            $answer->question->decrement('answers_count');
        });
    }
}
