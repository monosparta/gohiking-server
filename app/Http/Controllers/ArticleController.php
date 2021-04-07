<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $articles = Article::with('trails', 'trails.location', 'trails.location.county')->find($id);
        $userTrail = Favorite::select('trail_id')->where('user_id', '=', $request->uuid)->get();
        for ($i = 0; $i < count($articles->trails); $i++) {
            $articles->trails[$i]["favorite"] = false;
            for ($j = 0; $j < count($userTrail); $j++) {
                if ($articles->trails[$i]->id === $userTrail[$j]->trail_id) {
                    $articles->trails[$i]["favorite"] = true;
                }
            }
        }
        return $articles;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
