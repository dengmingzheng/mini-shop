<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DouCategoryRequest;
use App\Http\Requests\Admin\DouRegionRequest;
use App\Http\Requests\Admin\DouTagRequest;
use App\Http\Requests\Admin\DouTypeRequest;
use App\Services\DouCategoryService;
use App\Services\DouRegionService;
use App\Services\DouTagService;
use App\Services\DouTypeService;
use AccountLogService;

class DouCategoryController extends Controller
{
    //豆瓣分类列表
    public function index(DouCategoryRequest $request, DouCategoryService $douCategoryService)
    {
        $list = $douCategoryService->getListWithPage();

        return view('system.douCategories.index', ['list' => $list]);
    }

    /**
     * 添加豆瓣分类
     * @param DouCategoryRequest $request
     * @param DouCategoryService $douCategoryService
     */
    public function createCategory(DouCategoryRequest $request, DouCategoryService $douCategoryService)
    {
        if ($request->isMethod('POST')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'created_at' => get_current_time(),
                'updated_at' => get_current_time()
            ];

            $result = $douCategoryService->add($data);

            if ($result) {
                //写入日志
                AccountLogService::write('添加豆瓣分类,名称为:' . $data['title'], $data);

                return showMessage('添加成功', url('admin/douban'));
            } else {
                return showMessage('添加失败');
            }
        } else {
            return view('system.douCategories.create');
        }
    }

    /**
     * 编辑豆瓣分类
     * @param DouCategoryRequest $request
     * @param DouCategoryService $douCategoryService
     */
    public function editCategory(DouCategoryRequest $request, DouCategoryService $douCategoryService)
    {
        $id = $request->input('id');

        if ($request->isMethod('PUT')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'updated_at' => get_current_time()
            ];

            $result = $douCategoryService->update(['id' => $id], $data);

            if ($result) {
                //写入日志
                AccountLogService::write('编辑豆瓣分类,名称为:' . $data['title'], $data);

                return showMessage('编辑成功', url('admin/douban'));
            } else {
                return showMessage('编辑失败');
            }
        } else {

            if (!is_numeric($id) || !$id) {
                return showMessage('数据异常!');
            }

            $detail = $douCategoryService->select(['id', 'title'])->getRowById($id);

            return view('system.douCategories.edit', ['detail' => $detail]);
        }
    }

    /**
     * 删除豆瓣分类
     * @param DouCategoryRequest $request
     * @param DouCategoryService $douCategoryService
     */
    public function delCategory(DouCategoryRequest $request, DouCategoryService $douCategoryService)
    {
        if ($request->isMethod('DELETE')) {
            $ids = $request->input('ids');

            $result = $douCategoryService->destroy($ids);

            if ($result) {
                //写入后台日志
                $idString = implode(',',$ids);
                AccountLogService::write('删除豆瓣分类,ID为:' . $idString, []);

                return ['status' => 200, 'msg' => '删除成功'];
            } else {
                return ['status' => 0, 'msg' => '删除失败'];
            }
        }

    }

    /**
     * 豆瓣类型列表
     * @param DouTypeRequest $request
     * @param DouTypeService $douTypeService
     */
    public function types(DouTypeRequest $request, DouTypeService $douTypeService)
    {
        $list = $douTypeService->getListWithPage();

        return view('system.douTypes.index', ['list' => $list]);
    }

    /**
     * 添加豆瓣类型
     * @param DouTypeRequest $request
     * @param DouTypeService $douTypeService
     */
    public function createType(DouTypeRequest $request, DouTypeService $douTypeService)
    {
        if ($request->isMethod('POST')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'created_at' => get_current_time(),
                'updated_at' => get_current_time()
            ];

            $result = $douTypeService->add($data);

            if ($result) {
                //写入日志
                AccountLogService::write('添加豆瓣类型,名称为:' . $data['title'], $data);

                return showMessage('添加成功', url('admin/douban/types'));
            } else {
                return showMessage('添加失败');
            }
        } else {
            return view('system.douTypes.create');
        }
    }

    /**
     * 编辑豆瓣类型
     * @param DouTagRequest $request
     * @param DouTagService $douTagService
     */
    public function editType(DouTypeRequest $request, DouTypeService $douTypeService)
    {
        $id = $request->input('id');

        if ($request->isMethod('PUT')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'updated_at' => get_current_time()
            ];

            $result = $douTypeService->update(['id' => $id], $data);

            if ($result) {
                //写入日志
                AccountLogService::write('编辑豆瓣类型,名称为:' . $data['title'], $data);

                return showMessage('编辑成功', url('admin/douban/types'));
            } else {
                return showMessage('编辑失败');
            }
        } else {

            if (!is_numeric($id) || !$id) {
                return showMessage('数据异常!');
            }

            $detail = $douTypeService->select(['id', 'title'])->getRowById($id);

            return view('system.douTypes.edit', ['detail' => $detail]);
        }
    }

    /**
     * 删除豆瓣类型
     * @param DouTypeRequest $request
     * @param DouTypeService $douTypeService
     */
    public function delType(DouTypeRequest $request, DouTypeService $douTypeService)
    {
        if ($request->isMethod('DELETE')) {
            $ids = $request->input('ids');

            $result = $douTypeService->destroy($ids);

            if ($result) {
                //写入后台日志
                $ids = rtrim(',', implode(',', $ids));
                AccountLogService::write('删除豆瓣类型,ID为:' . $ids, []);

                return ['status' => 200, 'msg' => '删除成功'];
            } else {
                return ['status' => 0, 'msg' => '删除失败'];
            }
        }
    }

    /**
     * 豆瓣标签列表
     * @param DouTagRequest $request
     * @param DouTagService $douTagService
     */
    public function tags(DouTagRequest $request, DouTagService $douTagService)
    {
        $list = $douTagService->getListWithPage();

        return view('system.douTags.index', ['list' => $list]);
    }

    /**
     * 添加豆瓣标签
     * @param DouTagRequest $request
     * @param DouTagService $douTagService
     */
    public function createTag(DouTagRequest $request, DouTagService $douTagService)
    {
        if ($request->isMethod('POST')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'created_at' => get_current_time(),
                'updated_at' => get_current_time()
            ];

            $result = $douTagService->add($data);

            if ($result) {
                //写入日志
                AccountLogService::write('添加豆瓣标签,名称为:' . $data['title'], $data);

                return showMessage('添加成功', url('admin/douban/tags'));
            } else {
                return showMessage('添加失败');
            }
        } else {
            return view('system.douTags.create');
        }
    }

    /**
     * 编辑豆瓣标签
     * @param DouTagRequest $request
     * @param DouTagService $douTagService
     */
    public function editTag(DouTagRequest $request, DouTagService $douTagService)
    {
        $id = $request->input('id');

        if ($request->isMethod('PUT')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'updated_at' => get_current_time()
            ];

            $result = $douTagService->update(['id' => $id], $data);

            if ($result) {
                //写入日志
                AccountLogService::write('编辑豆瓣标签,名称为:' . $data['title'], $data);

                return showMessage('编辑成功', url('admin/douban/tags'));
            } else {
                return showMessage('编辑失败');
            }
        } else {

            if (!is_numeric($id) || !$id) {
                return showMessage('数据异常!');
            }

            $detail = $douTagService->select(['id', 'title'])->getRowById($id);

            return view('system.douTags.edit', ['detail' => $detail]);
        }
    }

    /**
     * 删除豆瓣标签
     * @param DouTagRequest $request
     * @param DouTagService $douTagService
     */
    public function delTag(DouTagRequest $request, DouTagService $douTagService)
    {
        if ($request->isMethod('DELETE')) {
            $ids = $request->input('ids');

            $result = $douTagService->destroy($ids);

            if ($result) {
                //写入后台日志
                $ids = rtrim(',', implode(',', $ids));
                AccountLogService::write('删除豆瓣标签,ID为:' . $ids, []);

                return ['status' => 200, 'msg' => '删除成功'];
            } else {
                return ['status' => 0, 'msg' => '删除失败'];
            }
        }

    }

    /**
     * 豆瓣地区列表
     * @param DouRegionRequest $request
     * @param DouRegionService $douRegionService
     */
    public function regions(DouRegionRequest $request, DouRegionService $douRegionService)
    {
        $list = $douRegionService->getListWithPage();

        return view('system.douRegions.index', ['list' => $list]);
    }

    /**
     * 添加豆瓣地区
     * @param DouRegionRequest $request
     * @param DouRegionService $douRegionService
     */
    public function createRegion(DouRegionRequest $request, DouRegionService $douRegionService)
    {
        if ($request->isMethod('POST')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'created_at' => get_current_time(),
                'updated_at' => get_current_time()
            ];

            $result = $douRegionService->add($data);

            if ($result) {
                //写入日志
                AccountLogService::write('添加豆瓣地区,名称为:' . $data['title'], $data);

                return showMessage('添加成功', url('admin/douban/regions'));
            } else {
                return showMessage('添加失败');
            }
        } else {
            return view('system.douRegions.create');
        }
    }

    /**
     * 编辑豆瓣地区
     * @param DouRegionRequest $request
     * @param DouRegionService $douRegionService
     */
    public function editRegion(DouRegionRequest $request, DouRegionService $douRegionService)
    {
        $id = $request->input('id');

        if ($request->isMethod('PUT')) {

            $input = $request->input();

            $data = [
                'title' => $input['title'],
                'updated_at' => get_current_time()
            ];

            $result = $douRegionService->update(['id' => $id], $data);

            if ($result) {
                //写入日志
                AccountLogService::write('编辑豆瓣地区,名称为:' . $data['title'], $data);

                return showMessage('编辑成功', url('admin/douban/regions'));
            } else {
                return showMessage('编辑失败');
            }
        } else {

            if (!is_numeric($id) || !$id) {
                return showMessage('数据异常!');
            }

            $detail = $douRegionService->select(['id', 'title'])->getRowById($id);

            return view('system.douRegions.edit', ['detail' => $detail]);
        }
    }

    /**
     * 删除豆瓣地区
     * @param DouRegionRequest $request
     * @param DouRegionService $douRegionService
     */
    public function delRegion(DouRegionRequest $request, DouRegionService $douRegionService)
    {
        if ($request->isMethod('DELETE')) {
            $ids = $request->input('ids');

            $result = $douRegionService->destroy($ids);

            if ($result) {
                //写入后台日志
                $ids = rtrim(',', implode(',', $ids));
                AccountLogService::write('删除豆瓣地区,ID为:' . $ids, []);

                return ['status' => 200, 'msg' => '删除成功'];
            } else {
                return ['status' => 0, 'msg' => '删除失败'];
            }
        }
    }
}
