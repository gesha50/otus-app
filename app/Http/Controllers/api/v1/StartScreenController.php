<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartScreen\StartScreenStoreRequest;
use App\Http\Requests\StartScreen\StartScreenUpdateRequest;
use App\Http\Resources\StartScreenCollection;
use App\Http\Resources\StartScreenResource;
use App\Models\StartScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class StartScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return StartScreenCollection
     */
    public function index(): StartScreenCollection
    {
        return Cache::remember('start_screens', 60*60*24, function () {
            return new StartScreenCollection(StartScreen::with('quiz')->get());
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StartScreenStoreRequest $request
     * @return StartScreenResource
     */
    public function store(StartScreenStoreRequest $request): StartScreenResource
    {
        $startScreen = StartScreen::create($request->all());
        if ($request->hasFile('image')){
            $startScreen->image = $request->file('image')->store('start-screens', 'public');
            $startScreen->save();
        }
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')->where('id', $id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param StartScreen $startScreen
     * @return StartScreenResource
     */
    public function show(StartScreen $startScreen): StartScreenResource
    {
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')
            ->where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StartScreenUpdateRequest $request
     * @param $id
     * @return StartScreenResource
     */
    public function update(StartScreenUpdateRequest $request, $id): StartScreenResource
    {
        $startScreen = StartScreen::find($id);
        $startScreen->update([
            'title' => $request->title,
            'description' => $request->description,
            'source' => $request->source,
            'quiz_id' => $request->quiz_id,
        ]);
        if ($request->hasFile('image')){
            Storage::disk('public')->delete($startScreen->image);
            $startScreen->image = $request->file('image')->store('start-screens', 'public');
            $startScreen->save();
        }
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')->where('id', $id)->first());
    }

    public function updateTitle(Request $request, $id): StartScreenResource
    {
        $startScreen = StartScreen::find($id);
        $startScreen->update([
            'title' => $request->title
        ]);
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')->where('id', $id)->get());
    }

    public function updateDescription(Request $request, $id): StartScreenResource
    {
        $startScreen = StartScreen::find($id);
        $startScreen->update([
            'description' => $request->description
        ]);
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')->where('id', $id)->get());
    }

    public function updateSource(Request $request, $id): StartScreenResource
    {
        $startScreen = StartScreen::find($id);
        $startScreen->update([
            'source' => $request->source
        ]);
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')->where('id', $id)->get());
    }

    public function updateImage(Request $request, $id): StartScreenResource
    {
        $startScreen = StartScreen::find($id);
        if ($request->hasFile('image')){
            Storage::disk('public')->delete($startScreen->image);
            $startScreen->image = $request->file('image')->store('start-screens', 'public');
            $startScreen->save();
        }
        $id = $startScreen->id;
        return new StartScreenResource($startScreen->with('quiz')->where('id', $id)->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StartScreen $startScreen
     * @return array
     */
    public function destroy(StartScreen $startScreen): array
    {
        Storage::disk('public')->delete($startScreen->image);
        $startScreen->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }

    public function deleteImage($id): array
    {
        $startScreen = StartScreen::find($id);
        Storage::disk('public')->delete($startScreen->image);
        $startScreen->update(['image'=> null]);
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
