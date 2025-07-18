<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generateQrCode($model, $path = 'product/qrcode') {
        $image = QrCode::format('svg')
                        ->size(600)
                        ->errorCorrection('H')
                        ->generate($model->product_code);

        $qrcodeName = $path . '/' . uniqid(). $model->id . '.svg';
        $qrcodePath = Storage::disk('public')->put($qrcodeName, $image);
        return Storage::url($qrcodeName);
    }
}
