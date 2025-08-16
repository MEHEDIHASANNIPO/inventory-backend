<?php
namespace App\Repositories\Backup;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupRepository implements BackupInterface
{
    /*
     * @return mixed|void
     */
    public function allPaginate()
    {
        $disk  = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->files(config('backup.backup.name'));

        $backups = [];

        foreach ($files as $key => $file) {
            if (substr($file, -4) == '.zip' && $disk->exists($file)) {
                $file_name = str_replace(config('backup.backup.name') . '/', '', $file);

                $backups[] = [
                    'file_path'     => $file,
                    'file_name'     => $file_name,
                    'file_size'     => $this->byteToHuman($disk->size($file)),
                    'created_at'    => Carbon::parse($disk->lastModified($file))->diffForHumans(),
                    'download_link' => '#',
                ];
            }
        }


        if(count($backups) != 0) {
            $backups = array_reverse($backups);
        } else {
            $backups = [];
        }

        return $backups;
    }

    /*
    * Convert bytes to human readable
    * @param $bytes
    * @return string
    */
    private function byteToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store()
    {
        $data = Artisan::call('backup:run', [
            '--only-db' => true,
        ]);

        return $data;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function delete($file_name)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists(config('backup.backup.name') . '/' . $file_name)) {
            $disk->delete(config('backup.backup.name') . '/' . $file_name);
        }

        return true;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function download($file_name)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $file = config('backup.backup.name') . '/' . $file_name;

        if ($disk->exists($file)) {
            $fs     = Storage::disk(config('backup.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type"        => '.zip',
                "Content-Length"      => $disk->size($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        }
    }
}
