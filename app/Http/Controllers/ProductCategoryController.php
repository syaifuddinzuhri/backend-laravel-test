<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProductCategoryRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = $this->repository->index($request);
            return response()->success($data, 'Data berhasil didapatkan!');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        try {
            $data = $this->repository->store($request);
            return response()->success($data, 'Data berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->repository->getDetailById($id);
            return response()->success($data, 'Data berhasil didapatkan!');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, $id)
    {
        try {
            $data = $this->repository->update($request, $id);
            return response()->success($data, 'Data berhasil diubah!');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->repository->delete($id);
            return response()->success($data, 'Data berhasil dihapus!');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }
}
