<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Storage;

class PostImageRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\PostImage";
    }

    public function deleteWithArrayOfId($imageIds, $post_id)
    {
        if($imageIds  && $post_id) {
            foreach ($imageIds as $imageId) {
                $this->deleteWhere(['id'      => $imageId,
                                    'post_id' => $post_id]);
            }
        }
    }

    public function createMulti($photos, $post_id){
        if ($photos && $post_id) {
            foreach ($photos as $photo) {
                $pathFile = Storage::put('public/images/post/'.$post_id, $photo);
                $pathFileArray = explode('/', $pathFile);
                $filename = $pathFileArray[count($pathFileArray) - 1];
                $this->create(["post_id" => $post_id,
                                              "image"   => $filename,]);
            }
        }
    }
}
