<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultDetail\ResultDetailStoreRequest;
use App\Http\Requests\ResultDetail\ResultDetailUpdateRequest;
use App\Http\Resources\ResultDetailCollection;
use App\Http\Resources\ResultDetailResource;
use App\Models\ResultDetail;
use Illuminate\Support\Facades\Cache;

class ResultDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResultDetailCollection
     */
    public function index(): ResultDetailCollection
    {
        return Cache::remember('result-details', 60*60*24, function () {
            return new ResultDetailCollection(
                ResultDetail::with('result', 'question')->get()
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResultDetailStoreRequest $request
     * @return ResultDetailResource
     */
    public function store(ResultDetailStoreRequest $request): ResultDetailResource
    {
        $resultDetail = ResultDetail::create($request->all());
        $id = $resultDetail->id;
        return new ResultDetailResource(
            $resultDetail->with('result', 'question')->where('id', $id)->first()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param ResultDetail $resultDetail
     * @return ResultDetailResource
     */
    public function show(ResultDetail $resultDetail): ResultDetailResource
    {
        $id = $resultDetail->id;
        return new ResultDetailResource(
            $resultDetail->with('result', 'question')->where('id', $id)->first()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultDetailUpdateRequest $request
     * @param $id
     * @return ResultDetailResource
     */
    public function update(ResultDetailUpdateRequest $request, $id): ResultDetailResource
    {
        $resultDetail = ResultDetail::find($id);
        $resultDetail->update($request->all());
        $id = $resultDetail->id;
        return new ResultDetailResource(
            $resultDetail->with('result', 'question')->where('id', $id)->first()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ResultDetail $resultDetail
     * @return array
     */
    public function destroy(ResultDetail $resultDetail): array
    {
        $resultDetail->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
