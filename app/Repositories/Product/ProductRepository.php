<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Service\QrCodeService;
use App\Service\BarCodeService;
use App\Service\FileUploadService;

class ProductRepository implements ProductInterface
{
    private $filePaths = 'product';
    /*
     * @return mixed|void
     */
    public function all()
    {
        $data = Product::latest('id')
            ->select(['id', 'product_name', 'product_code', 'original_price', 'sell_price', 'stock', 'file', 'qrcode', 'is_active', 'updated_at'])
            ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage)
    {
        $data = Product::latest('id')
            ->when(request('search'), function ($query) {
                $query->where('product_name', 'like', '%' . request('search') . '%')
                    ->orWhere('product_code', 'like', '%' . request('search') . '%');
            })
            ->select(['id', 'product_name', 'product_code', 'original_price', 'sell_price', 'stock', 'file', 'qrcode', 'is_active', 'updated_at'])
            ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data)
    {
        $data = Product::create([
            'category_id'      => $requested_data->category_id,
            'brand_id'         => $requested_data->brand_id,
            'supplier_id'      => $requested_data->supplier_id,
            'warehouse_id'     => $requested_data->warehouse_id,
            'product_name'     => $requested_data->product_name,
            'product_slug'     => Str::slug($requested_data->product_name),
            'product_code'     => uniqid() . rand(99, 9999),
            'original_price'   => $requested_data->original_price,
            'sell_price'       => $requested_data->sell_price,
            'stock'            => $requested_data->stock,
            'description'      => $requested_data->description,
        ]);

        // QrCode & BarCode
        $qrcodePath = ((new QrCodeService))->generateQrCode($data);
        $barcodePath = ((new BarCodeService))->generateBarCode($data);

        $data->update([
            'qrcode' => $qrcodePath,
            'barcode' => $barcodePath
        ]);

        // Image Upload
        if($requested_data->file != null) {
            $imagePath = (new FileUploadService())->imageUpload($requested_data, $data, $this->filePaths);

            $data->update([
                'file' => $imagePath
            ]);
        }

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id)
    {
        $data = $this->show($id);

        $data->update([
            'category_id'      => $requested_data->category_id,
            'brand_id'         => $requested_data->brand_id,
            'supplier_id'      => $requested_data->supplier_id,
            'warehouse_id'     => $requested_data->warehouse_id,
            'product_name'     => $requested_data->product_name,
            'product_slug'     => Str::slug($requested_data->product_name),
            'original_price'   => $requested_data->original_price,
            'sell_price'       => $requested_data->sell_price,
            'stock'            => $requested_data->stock,
            'description'      => $requested_data->description,
        ]);

        // Image Upload
        if($requested_data->file != null) {
            $imagePath = (new FileUploadService())->imageUpload($requested_data, $data, $this->filePaths);

            $data->update([
                'file' => $imagePath
            ]);
        }

        return $data;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();

        return true;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function status($id)
    {
        $data = $this->show($id);

        if ($data->is_active == 0) {
            $data->is_active = 1;
        } elseif ($data->is_active == 1) {
            $data->is_active = 0;
        }

        $data->save();

        return $data;
    }
}
