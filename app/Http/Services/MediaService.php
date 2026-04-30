<?php

namespace App\Http\Services;


class MediaService
{
    public function getMedia(object $model, string $collection = 'image_default')
    {
        return $model->getMedia($collection)->map(function ($item) {
            return [
                'id' => $item->id,
                'file_name' => $item->file_name,
                'url' => $item->getUrl(),
            ];
        });
    }
    public function createMedia(object $model, object $file, string $collection = 'image_default')
    {
        return $model->addMedia($file)->toMediaCollection($collection);
    }
    public function updateMedia(object $model, object $file, string $collection = 'image_default')
    {
        return $this->createMedia($model, $file, $collection);
    }
    public function deleteMedia(object $model, string $collection = 'image_default')
    {
        if ($model->hasMedia($collection)) {
            return $model->clearMediaCollection($collection);
        }
    }
}
