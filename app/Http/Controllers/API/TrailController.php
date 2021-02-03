<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trail;
use Illuminate\Http\Request;

class TrailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trail = Trail::with('location','location.county')->where('id','>=',1);
        // 篩選欄位條件
        if (isset($request->filters)) {
            $filters = explode(',', $request->filters);
            $countieFilter='';
            foreach ($filters as $key => $filter) {
                //迴圈取得所有filter參數
                list($criteria, $value) = explode(':', $filter);
                switch ($criteria) {
                    case 'title':
                        $trail->where($criteria, 'like', "%$value%");
                        break;
                    case 'difficulty':
                    case 'evaluation':
                        $trail->where($criteria, '=', "$value");
                        break;
                    case 'altitude1':
                        $trail->where('altitude','>=',$value);
                        break;
                    case 'altitude2':
                        $trail->where('altitude','<=',$value);
                        break;
                    case 'countie':
                        $trail->whereHas('location.countie',function($q) use($value){
                            $q->where('name','like',"%$value%");
                        });
                        break;
                    case 'collection':
                        $trail->whereHas('collections',function($q) use($value){
                            $q->where('collection_id',$value);
                        });
                        break;
                    default:
                        break;
                }
            }
            $result=$trail->get();
        }
        return $result;
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
    public function show($id)
    {
        $result = trail::with('location','location.county')->where('id',$id)->get(); //查詢id動作
        return $result;
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
