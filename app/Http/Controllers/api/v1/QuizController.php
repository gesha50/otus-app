<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\QuizStoreRequest;
use App\Http\Requests\Quiz\QuizUpdateRequest;
use App\Http\Resources\QuizCollection;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return QuizCollection
     */
    public function index(): QuizCollection
    {
        return Cache::remember('quizzes', 60*60*24, function () {
            return new QuizCollection(
                Quiz::with('user', 'start_screen', 'category', 'questions.answers')
                ->get()
            );
        });
    }

    public function userQuizzes(): QuizCollection
    {
//        return Cache::remember('userQuizzes', 60*60*24, function () {
            return new QuizCollection(
                Quiz::where('user_id', Auth::user()->id)
                    ->with('user', 'start_screen', 'category', 'questions.answers')
                    ->get()
            );
//        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuizStoreRequest $request
     * @return QuizResource
     */
    public function store(QuizStoreRequest $request): QuizResource
    {
        $quiz = Quiz::create($request->all());
        if ($request->hasFile('image')){
            $quiz->image = $request->file('image')->store('quizzes', 'public');
            $quiz->save();
        }
        $id = $quiz->id;
        return new QuizResource(
            $quiz->with('user', 'start_screen', 'category', 'questions.answers')->where('id', $id)->first()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Quiz $quiz
     * @return QuizResource
     */
    public function show(Quiz $quiz): QuizResource
    {
        $id = $quiz->id;
        return new QuizResource(
            $quiz->with('user', 'start_screen', 'category', 'questions.answers')
                ->where('id', $id)->first()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuizUpdateRequest $request
     * @param $id
     * @return QuizResource
     */
    public function update(QuizUpdateRequest $request, $id): QuizResource
    {
        $quiz = Quiz::find($id);
        $quiz->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'link' => $request->link,
            'is_visible' => $request->is_visible
        ]);
        if ($request->hasFile('image')){
            Storage::disk('public')->delete($quiz->image);
            $quiz->image = $request->file('image')->store('quizzes', 'public');
            $quiz->save();
        }
        $id = $quiz->id;
        return new QuizResource(
            $quiz->with('user', 'start_screen', 'category', 'questions.answers')->where('id', $id)->first()
        );
    }

    public function updateCategory(Request $request, $id): QuizResource
    {
        $quiz = Quiz::find($id);
        $quiz->update([
            'category_id' => (int)$request->category_id
        ]);
        $id = $quiz->id;
        return new QuizResource(
            $quiz->with('user', 'start_screen', 'category', 'questions.answers')->where('id', $id)->first()
        );
    }

    public function updateIsVisible(Request $request, $id): QuizResource
    {
        $quiz = Quiz::find($id);
        if ($request->is_visible) {
            $is_visible = 1;
        } else {
            $is_visible = 0;
        }
        $quiz->update([
            'is_visible' => $is_visible
        ]);
        $id = $quiz->id;
        return new QuizResource(
            $quiz->with('user', 'start_screen', 'category', 'questions.answers')->where('id', $id)->first()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Quiz $quiz
     * @return array
     */
    public function destroy(Quiz $quiz): array
    {
        Storage::disk('public')->delete($quiz->image);
        $quiz->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
