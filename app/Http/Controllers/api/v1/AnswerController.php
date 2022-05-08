<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Answer\AnswerStoreRequest;
use App\Http\Requests\Answer\AnswerUpdateRequest;
use App\Http\Resources\AnswerCollection;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use Illuminate\Support\Facades\Cache;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnswerCollection
     */
    public function index(): AnswerCollection
    {
        return Cache::remember('answers', 60*60*24, function () {
            return new AnswerCollection(Answer::with('question.quiz')->get());
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnswerStoreRequest $request
     * @return AnswerResource
     */
    public function store(AnswerStoreRequest $request): AnswerResource
    {
        $answer = Answer::create($request->all());
        $id = $answer->id;
        return new AnswerResource($answer->with('question.quiz')->where('id', $id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param Answer $answer
     * @return AnswerResource
     */
    public function show(Answer $answer): AnswerResource
    {
        $id = $answer->id;
        return new AnswerResource(
            $answer->with('question.quiz')->where('id', $id)->get()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AnswerUpdateRequest $request
     * @param $id
     * @return AnswerResource
     */
    public function update(AnswerUpdateRequest $request, $id): AnswerResource
    {
        $answer = Answer::find($id);
        $answer->update($request->all());
        $id = $answer->id;
        return new AnswerResource(
            $answer->with('question.quiz')->where('id', $id)->get()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Answer $answer
     * @return array
     */
    public function destroy(Answer $answer): array
    {
        $answer->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
