<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Traits\GlobalTrait;

class ProductCategoryRepository
{

    use GlobalTrait;

    public function __construct()
    {
    }

    public function index($request)
    {
        try {
            $filter =  [
                'name',
            ];
            $query = ProductCategory::whereLike($filter, $request->keyword);
            $result = $this->datatables($request, $query);
            return $result;
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }

    public function getDetailById($id)
    {
        try {
            $data = ProductCategory::find($id);
            if (!$data) $this->ApiException('Data kategori produk tidak ditemukan');
            return $data;
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }

    public function store($request)
    {
        try {
            $payload = $request->all();
            $result = ProductCategory::create($payload);
            return $this->getDetailById($result->id);
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }

    public function update($request, $id)
    {
        try {
            $payload = $request->all();
            $data = $this->getDetailById($id);
            $data->update($payload);
            return $this->getDetailById($data->id);
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->getDetailById($id);
            $data->delete();
            return NULL;
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }
}
