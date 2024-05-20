<?php

namespace App\Repositories;

use App\Constant\UploadPathConstant;
use App\Models\Product;
use App\Traits\GlobalTrait;
use App\Traits\UploadFileTrait;

class ProductRepository
{

    use GlobalTrait, UploadFileTrait;

    private $productCategoryRepository;

    public function __construct()
    {
        $this->productCategoryRepository = new ProductCategoryRepository();
    }

    public function index($request)
    {
        try {
            $filter =  [
                'name',
                'category.name'
            ];
            $query = Product::with(['category'])->whereLike($filter, $request->keyword);
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
            $data = Product::with(['category'])->find($id);
            if (!$data) $this->ApiException('Data produk tidak ditemukan');
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

            $this->productCategoryRepository->getDetailById($payload['product_category_id']);

            if ($request->hasFile('image') || $request->image != null) {
                $file = $request->file('image');
                $file_name = $this->uploadImage($file, UploadPathConstant::PRODUCT_IMAGE);
                $payload['image'] = $file_name;
            }
            $result = Product::create($payload);
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

            $this->productCategoryRepository->getDetailById($payload['product_category_id']);

            if ($request->hasFile('image') || $request->image != null) {
                $file = $request->file('image');
                $file_name = $this->uploadImage($file, UploadPathConstant::PRODUCT_IMAGE);
                $payload['image'] = $file_name;
                if ($data->image) {
                    $image_old = explode('/', $data->image);
                    $this->unlinkImage(UploadPathConstant::PRODUCT_IMAGE, end($image_old));
                }
            }
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
            if ($data->image) {
                $image_old = explode('/', $data->image);
                $this->unlinkImage(UploadPathConstant::PRODUCT_IMAGE, end($image_old));
            }
            $data->delete();
            return NULL;
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }
}
