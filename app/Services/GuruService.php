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
    public function __construct(protected GuruRepository $guruRepository) {}

    public function getAllGurus()
    {
        return $this->guruRepository->getAll();
    }

    public function getGuruById(int $id)
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
                        $isiGuru['photo'] = $this->uploadPhoto($isiGuru['photo']);
                    }
                    $result[] = $this->guruRepository->create($isiGuru);
                }
                return $result;
            }

            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $data['array'] = $this->uploadPhoto($data['photo']);
            }

            return $this->guruRepository->create($data);
        });
    }

    public function updateGuru(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $guru = $this->getGuruById($id);

            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $this->deletePhoto($guru->photo);
                return $data['photo'] = $this->uploadPhoto($data['photo']);
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

    private function uploadPhoto(UploadedFile $photo)
    {
        return $photo->store('guru', 'public');
    }

    private function deletePhoto(string $path)
    {
        $relativePath = 'guru/' . basename($path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
