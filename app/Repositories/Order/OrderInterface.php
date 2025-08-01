<?php

namespace App\Repositories\Order;

interface OrderInterface
{
    public function allPaginate($perPage);
    public function store($data);
    public function show($id);
    public function invoiceDownload($id);
}
