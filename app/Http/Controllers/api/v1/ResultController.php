<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Result\ResultStoreRequest;
use App\Http\Requests\Result\ResultUpdateRequest;
use App\Http\Resources\ResultCollection;
use App\Http\Resources\ResultResource;
use App\Models\Result;
use Illuminate\Support\Facades\Cache;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResultCollection
     */
    public function index(): ResultCollection
    {
        return Cache::remember('results', 60*60*24, function () {
            return new ResultCollection(
                Result::with(
                    'user',
                    'result_details.question.answers',
                    'quiz.category',
                    'quiz.questions.answers',
                    'quiz.user'
                )->get()
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResultStoreRequest $request
     * @return ResultResource
     */
    public function store(ResultStoreRequest $request): ResultResource
    {
        $result = Result::create($request->all());
        $id = $result->id;
        return new ResultResource($result->with(
            'user',
            'result_details.answer.question',
            'quiz.category',
            'quiz.questions.answers',
            'quiz.user'
        )->where('id', $id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param Result $result
     * @return ResultResource
     */
    public function show(Result $result): ResultResource
    {
        $id = $result->id;
        return new ResultResource($result->with(
            'user',
            'result_details.answer.question',
            'quiz.category',
            'quiz.questions.answers',
            'quiz.user'
        )->where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultUpdateRequest $request
     * @param $id
     * @return ResultResource
     */
    public function update(ResultUpdateRequest $request, $id): ResultResource
    {
        $result = Result::find($id);
        $result->update($request->all());
        $id = $result->id;
        return new ResultResource($result->with(
            'user',
            'result_details.answer.question',
            'quiz.category',
            'quiz.questions.answers',
            'quiz.user'
        )->where('id', $id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Result $result
     * @return array
     */
    public function destroy(Result $result): array
    {
        $result->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
