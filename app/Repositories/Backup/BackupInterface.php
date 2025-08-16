<?php

namespace App\Repositories\Backup;

interface BackupInterface
{
    public function allPaginate();
    public function store();
    public function delete($name);
    public function download($name);
}
