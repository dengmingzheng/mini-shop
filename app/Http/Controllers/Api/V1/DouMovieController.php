<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DouMovieService;
use App\Services\UserService;
use App\Services\DouCommentService;

class DouMovieController extends Controller
{
    /**
     * @影视列表
     * @param Request $request
     * @param DouMovieService $douMovieService
     * @return mixed
     */
    public function movieList(Request $request,DouMovieService $douMovieService)
    {
        $count = $request->input('count');
        $type = $request->input('type');
        $keyword = $request->input('keyword');

        $field = ['id','ch_title','zh_title','rate','image_path','year'];
        $condition = [];

        if($type === 'movies'){
            $condition['category_id'] = 5;
        }elseif ($type === 'tvs'){
            $condition['category_id'] = 6;
        }elseif ($type === 'shows'){
            $condition['category_id'] = 7;
        }elseif ($type === 'comics'){
            $condition['category_id'] = 8;
        }elseif ($type === 'tvs'){
            $condition['category_id'] = 10;
        }elseif ($type === 'records'){
            $condition['category_id'] = 11;
        }

        if(!empty($keyword)){
            $condition[] = ['ch_title','like','%'.$keyword.'%'];
        }

        $list = $douMovieService->select($field)->getList($condition,[],'rate','DESC','',$count);

        return $list;
    }

    /**
     * @获取详细数据
     * @param Request $request
     * @param DouMovieService $douMovieService
     * @param UserService $userService
     * @param DouCommentService $douCommentService
     * @return array
     */
    public function detail(Request $request,DouMovieService $douMovieService,UserService $userService,DouCommentService $douCommentService)
    {
        $id = $request->input('id');

        if(!is_numeric($id) || !$id){
            return [];
        }

       $data = $douMovieService->getRowById($id);

       //取三条评论
        $data['comments'] = $douCommentService->getList(['movie_id'=>$data['id']],['user'],'id','DESC',0,3);

       return $data;

    }

    /**
     * @获取评论列表
     * @param Request $request
     * @param DouCommentService $douCommentService
     * @return array|mixed
     */
    public function comments(Request $request,DouCommentService $douCommentService)
    {
            $movie_id = $request->input('movie_id');
            $condition = [];

            if(!is_numeric($movie_id) || !$movie_id){
                return [];
            }
            $condition['movie_id'] = $movie_id;
            return   $comments = $douCommentService->getListWithPage($condition,['user']);
    }
}
