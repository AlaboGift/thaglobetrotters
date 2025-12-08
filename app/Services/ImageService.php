<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use App\Models\General\Image as ImageModel;
use App\Utils\Constants;
use App\Utils\Utils;
use Exception;
use Image;

class ImageService
{

    public function addImages($params)
    {
        $images = [];
        $sizeAndLocation = Utils::getSizeAndLocation($params->type, $params->id);
        $failedCount = 0;
    
        foreach ($params->file('fileInput') as $file) {
            try {
                array_push($images, $this->imageHandler($sizeAndLocation->uploader, $file, $params->type));
                
            } catch (Exception $e) {
                $failedCount++;
                \Log::error('Image upload failed: ' . $e->getMessage(), [
                    'file' => $file->getClientOriginalName(),
                    'type' => $params->type,
                    'id' => $params->id
                ]);
            }
        }
    
        return [
            'failed' => $failedCount,
            'images' => $images
        ];
    }

    public function getImages($model)
    {
        return $model->images()->latest()->paginate(Constants::PAGINATION_PER_PAGE);
    }

    public function getImagesByType($types)
    {
        return ImageModel::whereIn('image_type', $types)->latest()->paginate(Constants::PAGINATION_PER_PAGE);
    }

    public function imageHandler($model, $file)
    {
        $fileName = time().'_'.$file->getClientOriginalName();
 
        return $model->images()->create([
            'path' => 'uploads/'.$fileName,
            'url' => photo("file","uploads/","assets/"),
            'name' => $file->getClientOriginalName()
        ]);
    }

    public function deleteFile($id)
    {
        $image = ImageModel::find($id);

        if(!$image){
            throw new Exception("Image not found");
        }

        $this->removeFile($image->url);
        $image->delete();

        return true;
    }

    public function delete($id)
    {

        $image = ImageModel::find($id);

        if(!$image){
            throw new Exception("Image not found");
        }

        if (Storage::disk('local')->exists($image->path)) {
            Storage::disk('local')->delete($image->path);
        }

        $image->delete();

        return true;
    }

    public function default($id)
    {
        $image = ImageModel::find($id);

        if(!$image){
            throw new Exception("Image not found");
        }

        $image->update(['is_default' => true]);

        return $image;
    }
    
    public function makeDirectory($path)
    {
        if (file_exists($path)) return true;
        return mkdir($path, 0755, true);
    }

    public function removeFile($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }

    public function uploadImage($file, $location, $filename = null, $size = null, $old = null, $thumb = null)
    {
        $path = $this->makeDirectory($location);
        if (!$path) throw new Exception('File could not been created.');

        if (!empty($old)) {
            $this->removeFile($old);
            //$this->removeFile($location . '/thumb_' . $old);
        }

        if ($filename == null) {
            $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        }

        if(strtolower($file->getClientOriginalExtension()) == 'pdf'){
            $file->move($location, $filename);
        }else{
            $image = Image::make($file);

            if (!empty($size)) {
                $size = explode('x', strtolower($size));
                $image->resize($size[0], $size[1]);
            }

            $image->save($location . '/' . $filename);

            if (!empty($thumb)) {
                $thumb = explode('x', $thumb);
                Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
            }
        }

        return $location.$filename;

    }
}

