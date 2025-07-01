<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSystemSettingRequest;
use App\Repositories\SystemSetting\SystemSettingInterface;

class SystemSettingController extends Controller
{
    use ApiResponse;

    private $systemSettingRepository;

    public function __construct(SystemSettingInterface $systemSettingRepository) {
        $this->systemSettingRepository = $systemSettingRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->systemSettingRepository->all();

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Display a listing of the timezone.
     */
    public function siteTimeZone()
    {
        $data = $this->systemSettingRepository->siteTimeZone();

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemSettingRequest $request, $id)
    {
        $data = $this->systemSettingRepository->update($request, $id);

        try {
            return $this->ResponseSuccess($data, null, 'Updated Successfully!');
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Change Status of specified resource from storage.
     */
    public function status(string $id)
    {
        //
    }
}
