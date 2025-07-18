<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;


class BarCodeService
{
    public function generateBarCode($model, $path = 'product/barcode') {
        $generatorPNG = new BarcodeGeneratorPNG();
        $image = $generatorPNG->getBarcode($model->product_code, $generatorPNG::TYPE_CODE_128);

        $barcodeName = $path . '/' . uniqid(). $model->id . '.png';
        $barcodePath = Storage::disk('public')->put($barcodeName, $image);
        return Storage::url($barcodeName);
    }
}
