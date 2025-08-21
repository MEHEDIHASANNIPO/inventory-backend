<?php

namespace App\Repositories\Transfer;

interface TransferInterface
{
    public function all();
    public function allPaginate($perPage);
    public function store($data);
    public function show($id);
    public function delete($id);
}
