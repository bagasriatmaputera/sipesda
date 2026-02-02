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

    public function getAll()
    {
        return $this->siswaRepository->getAll();
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
                        $item['photo'] = $this->uploadPhoto($item['photo'], $data['nama']);
                    }
                    $result[] = $this->siswaRepository->create($item);
                }
                return $result;
            }

            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $data['photo'] = $this->uploadPhoto($data['photo'], $data['nama']);
            }

            return $this->siswaRepository->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        $siswa = $this->getById($id);
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            if (!empty($siswa->photo)) {
                $this->deletePhoto($siswa->photo);
            }

            $data['photo'] = $this->uploadPhoto($data['photo'], $data['nama'] ?? $siswa->nama);
        }
        $update = $this->siswaRepository->update($id, $data);
        if ($update) {
            return $update;
        }

        return throw new \Exception('Gagal Update', 422);

    }

    public function delete(int $id)
    {
        return $this->siswaRepository->delete($id);
    }

    private function uploadPhoto(UploadedFile $photo, string $namaSiswa)
    {
        $extension = $photo->getClientOriginalExtension();
        $fileName = \Illuminate\Support\Str::slug($namaSiswa) . time() . '-profile.' . $extension;
        return $photo->storeAs('photos/siswa', $fileName, 'public');
    }

    private function deletePhoto(string $path)
    {
        if (!$path) {
            return;
        }
        $relativePath = 'photos/siswa/' . basename($path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
