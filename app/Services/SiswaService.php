<?php

namespace App\Services;

use App\Repository\SiswaRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class siswaService
{
    protected SiswaRepository $siswaRepository;

    public function __construct(SiswaRepository $siswaRepository)
    {
        $this->siswaRepository = $siswaRepository;
    }

    public function getAll(array $fields)
    {
        return $this->siswaRepository->getAll($fields);
    }

    public function getById(int $id)
    {
        return $this->siswaRepository->getById($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data[0]) && is_array($data[0])) {
                $result = [];
                foreach ($data as $item) {
                    if (isset($item['photo']) && $item['photo'] instanceof UploadedFile) {
                        $item['photo'] = $this->uploadPhoto($item['photo']);
                    }
                    $result[] = $this->siswaRepository->create($item);
                }
                return $result;
            }

            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $data['photo'] = $this->uploadPhoto($data['photo']);
            }

            return $this->siswaRepository->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        $siswa = $this->getById($id);
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            return $this->deletePhoto($siswa->photo);
        }
        $data['photo'] = $this->uploadPhoto($data['photo']);
        return $this->siswaRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->siswaRepository->delete($id);
    }

    private function uploadPhoto(UploadedFile $photo)
    {
        return $photo->store('siswa', 'public');
    }

    private function deletePhoto(string $path)
    {
        $relativePath = 'siswa/' . basename($path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
