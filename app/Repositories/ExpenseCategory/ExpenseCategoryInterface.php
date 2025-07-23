<?php

namespace App\Repositories\ExpenseCategory;

interface ExpenseCategoryInterface
{
    public function all();
    public function allPaginate($perPage);
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function delete($id);
    public function status($id);
}
