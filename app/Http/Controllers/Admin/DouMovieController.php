<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DouMovieRequest;
use App\Http\Requests\Admin\DouCommentRequest;
use App\Services\DouMovieService;
use App\Services\DouCategoryService;
use App\Services\DouRegionService;
use App\Services\DouTagService;
use App\Services\DouTypeService;
use App\Services\DouCommentService;
use App\Tools\ImageUploadHandler;
use App\Services\UserService;
use AccountLogService;

class DouMovieController extends Controller
{
    /**
     * @豆瓣影视列表
     * @param DouMovieRequest $request
     * @param DouMovieService $douMovieService
     * @param DouCategoryService $douCategoryService
     * @param DouRegionService $douRegionService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DouMovieRequest $request, DouMovieService $douMovieService, DouCategoryService $douCategoryService, DouRegionService $douRegionService)
    {
        $condition = [];
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $region_id = $request->input('region_id');
        $year = $request->input('year');

        if (isset($title) && !empty($title)) {
            $condition[] = ['ch_title', 'like', '%' . $title . '%'];
        }

        if (isset($category_id) && !empty($category_id)) {
            $condition['category_id'] = $category_id;
        }

        if (isset($region_id) && !empty($region_id)) {
            $condition['region_id'] = $region_id;
        }

        if (isset($year) && !empty($year)) {
            $condition['year'] = $year;
        }

        $list = $douMovieService->getListWithPage($condition, ['category']);

        $categoryList = $douCategoryService->select(['id', 'title'])->getList(); //获取分类列表
        $regionList = $douRegionService->select(['id', 'title'])->getList(); //获取地区列表

        return view('system.douMovies.index', ['list' => $list, 'categoryList' => $categoryList, 'regionList' => $regionList]);
    }

    /**
     * @添加豆瓣影视
     * @param DouMovieRequest $request
     * @param DouMovieService $douMovieService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(DouMovieRequest $request, DouMovieService $douMovieService)
    {
        $douRegionService = new DouRegionService();
        $douTagService = new DouTagService();
        $douTypeService = new DouTypeService();

        if ($request->isMethod('POST')) {
            $input = $request->input();

            $data = [
                'ch_title' => $input['ch_title'],
                'zh_title' => $input['zh_title'],
                'another_name' => $input['another_name'],
                'category_id' => $input['category_id'],
                'region_id' => $input['region_id'],
                'rate' => $input['rate'],
                'rate_num' => $input['rate_num'] ? $input['rate_num'] : 0,
                'comment_num' => $input['comment_num'] ? $input['comment_num'] : 0,
                'actors' => $input['actors'],
                'length_time' => $input['length_time'],
                'year' => $input['year'],
                'is_use' => $input['is_use'],
                'created_at' => get_current_time(),
                'updated_at' => get_current_time()
            ];

            //获取制片国家
            if ($input['region_id']) {
                $region = $douRegionService->select(['id', 'title'])->getRowById($input['region_id']);
                if (!empty($region)) {
                    $data['region_name'] = $region['title'];
                }
            }

            //获取类型
            if (!empty($input['types'])) {
                $types = implode(',', $input['types']);
                $typeList = $douTypeService->getListByIds($input['types'], ['id', 'title']);
                $types_name = '';
                foreach ($typeList as $value) {
                    $types_name .= $value['title'] . ',';
                }
                $types_name = rtrim($types_name, ',');

                $data['types'] = $types;
                $data['types_name'] = $types_name;
            }

            //获取标签
            if (!empty($input['tags'])) {
                $tags = implode(',', $input['tags']);
                $tagList = $douTagService->getListByIds($input['tags'], ['id', 'title']);
                $tags_name = '';

                foreach ($tagList as $value) {
                    $tags_name .= $value['title'] . ',';
                }
                $tags_name = rtrim($tags_name, ',');

                $data['tags'] = $tags;
                $data['tags_name'] = $tags_name;
            }

            //上传封面
            if ($request->image_path) {
                $imageUploadHandler = new ImageUploadHandler();

                $result = $imageUploadHandler->save($request->image_path, 'movies');

                if ($result['status']) {
                    $data['image_path'] = $result['path'];
                } else {
                    return showMessage($result['msg']);
                }
            }

            $result = $douMovieService->add($data);

            if ($result) {
                //写入后台日志
                $title = '添加影视,名称为:';
                if ($data['ch_title']) {
                    $title = $title . $data['ch_title'];
                } else {
                    $title = $title . $data['zh_title'];
                }

                AccountLogService::write($title, $data);

                return showMessage('添加成功', url('admin/douban/movies'));
            } else {
                return showMessage('添加失败');
            }

        } else {
            $douCategoryService = new DouCategoryService();

            $categoryList = $douCategoryService->select(['id', 'title'])->getList(); //获取分类列表
            $regionList = $douRegionService->select(['id', 'title'])->getList(); //获取地区列表
            $tagList = $douTagService->select(['id', 'title'])->getList(); //获取标签列表
            $typeList = $douTypeService->select(['id', 'title'])->getList(); //获取类型列表

            return view('system.douMovies.create', ['categoryList' => $categoryList, 'regionList' => $regionList, 'tagList' => $tagList, 'typeList' => $typeList]);
        }
    }

    public function edit(DouMovieRequest $request, DouMovieService $douMovieService)
    {
        $douRegionService = new DouRegionService();
        $douTagService = new DouTagService();
        $douTypeService = new DouTypeService();

        $id = $request->input('id');

        if ($request->isMethod('PUT')) {
            $input = $request->input();

            $data = [
                'ch_title' => $input['ch_title'],
                'zh_title' => $input['zh_title'],
                'another_name' => $input['another_name'],
                'category_id' => $input['category_id'],
                'region_id' => $input['region_id'],
                'rate' => $input['rate'],
                'rate_num' => $input['rate_num'] ? $input['rate_num'] : 0,
                'comment_num' => $input['comment_num'] ? $input['comment_num'] : 0,
                'actors' => $input['actors'],
                'length_time' => $input['length_time'],
                'year' => $input['year'],
                'is_use' => $input['is_use'],
                'created_at' => get_current_time(),
                'updated_at' => get_current_time()
            ];

            //获取制片国家
            if ($input['region_id']) {
                $region = $douRegionService->select(['id', 'title'])->getRowById($input['region_id']);
                if (!empty($region)) {
                    $data['region_name'] = $region['title'];
                }
            }

            //获取类型
            if (!empty($input['types'])) {
                $types = implode(',', $input['types']);
                $typeList = $douTypeService->getListByIds($input['types'], ['id', 'title']);
                $types_name = '';
                foreach ($typeList as $value) {
                    $types_name .= $value['title'] . ',';
                }
                $types_name = rtrim($types_name, ',');

                $data['types'] = $types;
                $data['types_name'] = $types_name;
            }

            //获取标签
            if (!empty($input['tags'])) {
                $tags = implode(',', $input['tags']);
                $tagList = $douTagService->getListByIds($input['tags'], ['id', 'title']);
                $tags_name = '';

                foreach ($tagList as $value) {
                    $tags_name .= $value['title'] . ',';
                }
                $tags_name = rtrim($tags_name, ',');

                $data['tags'] = $tags;
                $data['tags_name'] = $tags_name;
            }

            //上传封面
            if ($request->image_path) {
                $imageUploadHandler = new ImageUploadHandler();

                $result = $imageUploadHandler->save($request->image_path, 'movies');

                if ($result['status']) {
                    $data['image_path'] = $result['path'];
                } else {
                    return showMessage($result['msg']);
                }
            }

            $result = $douMovieService->update(['id' => $id], $data);

            if ($result) {
                //写入后台日志
                $title = '编辑影视,ID为:' . $id . ',名称为:';
                if ($data['ch_title']) {
                    $title = $title . $data['ch_title'];
                } else {
                    $title = $title . $data['zh_title'];
                }

                AccountLogService::write($title, $data);

                return showMessage('编辑成功', url('admin/douban/movies'));
            } else {
                return showMessage('编辑失败');
            }

        } else {

            $douCategoryService = new DouCategoryService();

            $categoryList = $douCategoryService->select(['id', 'title'])->getList(); //获取分类列表
            $regionList = $douRegionService->select(['id', 'title'])->getList(); //获取地区列表
            $tagList = $douTagService->select(['id', 'title'])->getList(); //获取标签列表
            $typeList = $douTypeService->select(['id', 'title'])->getList(); //获取类型列表

            $detail = $douMovieService->getRowById($id);
            $detail['types'] = explode(',', $detail['types']);
            $detail['tags'] = explode(',', $detail['tags']);

            return view('system.douMovies.edit', ['categoryList' => $categoryList, 'regionList' => $regionList, 'tagList' => $tagList, 'typeList' => $typeList, 'detail' => $detail]);
        }
    }

    /**
     * @删除豆瓣影视
     * @param DouMovieRequest $request
     * @param DouMovieService $douMovieService
     * @return array
     */
    public function del(DouMovieRequest $request, DouMovieService $douMovieService)
    {
        if ($request->isMethod('DELETE')) {
            $ids = $request->input('ids');

            $result = $douMovieService->destroy($ids);

            if ($result) {
                //写入后台日志
                $idString = implode(',',$ids);
                AccountLogService::write('删除豆瓣影视,ID为:' . $idString, []);

                return ['status' => 200, 'msg' => '删除成功'];
            } else {
                return ['status' => 0, 'msg' => '删除失败'];
            }
        }
    }

    /**
     * @评论列表
     * @param DouCommentRequest $request
     * @param DouCommentService $douCommentService
     * @param DouCategoryService $douCategoryService
     * @param DouMovieService $douMovieService
     * @param UserService $userService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comments(DouCommentRequest $request, DouCommentService $douCommentService, DouCategoryService $douCategoryService,DouMovieService $douMovieService,UserService $userService)
    {
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $name = $request->input('name');

        $condition = [];
        $where = [];

        if(!empty($title)){
            $condition[] = ['ch_title', 'like', '%' . $title . '%'];
        }

        if($category_id){
            $condition['category_id'] = $category_id;
        }

        if(!empty($condition)){
            $movie_ids = $douMovieService->getPluckValue('id',$condition);
        }

        if(!empty($name)){
            $whereUser[] = ['name', 'like', '%' . $name . '%'];
            $user_ids = $userService->getPluckValue('id',$whereUser);
        }

        if(!empty($movie_ids)){
            $where['movie_id'] = $movie_ids;
        }

        if(!empty($user_ids)){
            $where['user_id'] = $user_ids;
        }

        $list = $douCommentService->getListWithPageByCondition($where, ['movie', 'movie.category','user']);

        $categoryList = $douCategoryService->select(['id', 'title'])->getList(); //获取分类列表

        return view('system.douComments.index', ['list' => $list, 'categoryList' => $categoryList]);
    }

    public function detail(DouCommentRequest $request, DouCommentService $douCommentService)
    {
        $id = $request->input('id');

        if(!is_numeric($id) || !$id){
            return showMessage('非法参数!');
        }

        $detail = $douCommentService->getRowById($id,['movie','movie.category','user']);

        return view('system.douComments.detail', ['detail' => $detail]);

    }

    /**删除豆瓣评论
     * @param DouCommentRequest $request
     * @param DouCommentService $douCommentService
     * @return array
     */
    public function delComment(DouCommentRequest $request, DouCommentService $douCommentService)
    {
        if ($request->isMethod('DELETE')) {
            $ids = $request->input('ids');

            $result = $douCommentService->destroy($ids);

            if ($result) {
                //写入后台日志
                $idString = implode(',',$ids);
                AccountLogService::write('删除豆瓣评论,ID为:' . $idString, []);

                return ['status' => 200, 'msg' => '删除成功'];
            } else {
                return ['status' => 0, 'msg' => '删除失败'];
            }
        }
    }
}
