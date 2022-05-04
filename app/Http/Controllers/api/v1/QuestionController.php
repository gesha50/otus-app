<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return QuestionCollection
     */
    public function index(): QuestionCollection
    {
        return Cache::remember('questions', 60*60*24, function () {
            return new QuestionCollection(Question::with('quiz', 'answers')->get());
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionStoreRequest $request
     * @return QuestionResource
     */
    public function store(QuestionStoreRequest $request): QuestionResource
    {
        $question = Question::create($request->all());
        if ($request->hasFile('image')){
            $question->image  = $request->file('image')->store('questions', 'public');
            $question->save();
        }
        $id = $question->id;
        return new QuestionResource($question->with('quiz', 'answers')->where('id', $id)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question): QuestionResource
    {
        return new QuestionResource($question->with('quiz', 'answers')->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionUpdateRequest $request
     * @param $id
     * @return QuestionResource
     */
    public function update(QuestionUpdateRequest $request, $id): QuestionResource
    {
        $question = Question::find($id);
        $question->update([
            'title' => $request->title,
            'description' => $request->description,
            'bonus' => $request->bonus,
            'time_to_answer' => $request->time_to_answer,
            'quiz_id' => $request->quiz_id,
        ]);
        if ($request->hasFile('image')){
            Storage::disk('public')->delete($question->image);
            $question->image = $request->file('image')->store('questions', 'public');
            $question->save();
        }
        return new QuestionResource($question->with('quiz', 'answers')->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return array
     */
    public function destroy(Question $question): array
    {
        Storage::disk('public')->delete($question->image);
        $question->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
