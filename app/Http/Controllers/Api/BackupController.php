<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Backup\BackupInterface;

class BackupController extends Controller
{
    use ApiResponse;
    private $backupRepository;

    public function __construct(BackupInterface $backupRepository) {
        $this->backupRepository = $backupRepository;
    }

    /**
     * Display a paginated listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index-backup');

        try {
            $data = $this->backupRepository->allPaginate();
            $metadata['count'] = count($data);

            return $this->ResponseSuccess($data, $metadata);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-backup');

        try {
            $data = $this->backupRepository->store();
            return $this->ResponseSuccess($data, null, 'Backup Created Successfully!', 201);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        Gate::authorize('delete-backup');

        try {
            $data = $this->backupRepository->delete($name);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Download the specified resource.
     */
    public function download(string $name)
    {
        Gate::authorize('download-backup');

        try {
            return $data = $this->backupRepository->download($name);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
