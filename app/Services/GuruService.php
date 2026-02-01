<?php

namespace App\Services;

use App\Repository\GuruRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GuruService
{

    /**
     * Construct guruRepository
     */
    public function __construct(protected GuruRepository $guruRepository)
    {
    }

    public function getAllGurus()
    {
        return $this->guruRepository->getAll();
    }

    public function getGuruById($id)
    {
        return $this->guruRepository->getById($id);
    }

    public function storeGuru(array $data)
    {
        return DB::transaction(function () use ($data) {

            if (isset($data[0]) && is_array($data[0])) {
                $result = [];
                foreach ($data as $isiGuru) {
                    if (isset($isiGuru['photo']) && $isiGuru['photo'] instanceof UploadedFile) {
                        $isiGuru['photo'] = $this->uploadPhoto($isiGuru['photo'], $data['nama_guru']);
                    }
                    $result[] = $this->guruRepository->create($isiGuru);
                }
                return $result;
            }

            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $data['photo'] = $this->uploadPhoto($data['photo'], $data['nama_guru']);
            }

            return $this->guruRepository->create($data);
        });
    }

    public function updateGuru(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $guru = $this->getGuruById($id);

            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                if ($guru->photo) {
                    $this->deletePhoto($guru->photo);
                }
                $data['photo'] = $this->uploadPhoto($data['photo'], $data['nama_guru'] ?? $guru->nama_guru);
            }
            return $this->guruRepository->update($id, $data);
        });
    }

    public function deleteGuru(int $id)
    {
        try {
            return $this->guruRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception("Gagal menghapus data guru: " . $e->getMessage());
        }
    }

    private function uploadPhoto(UploadedFile $photo, string $namaGuru)
    {
        $extension = $photo->getClientOriginalExtension();
        $fileName = \Illuminate\Support\Str::slug($namaGuru) . time() . '-profile.' . $extension;
        return $photo->storeAs('photos/guru', $fileName, 'public');
    }

    private function deletePhoto(string $path)
    {
        $relativePath = 'photos/guru/' . basename($path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
