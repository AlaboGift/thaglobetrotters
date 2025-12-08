<?php

namespace App\Observers;
use App\Models\General\Image;

class ImageObserver
{
    /**
     * Handle the Image "created" event.
     *
     * @return void
     */
    public function created(Image $image)
    {
        // if the image is the first image of the imageable, set it as default
        if ($image->imageable->images->count() === 1) {
            $image->update(['is_default' => true]);
        }
    }

    /**
     * Handle the Image "updated" event.
     *
     * @return void
     */
    public function updated(Image $image)
    {
        // If the image was set as default
        if ($image->isDirty('is_default') && $image->is_default) {
            // Set is_default to false for all other images of the same imageable
            Image::where('imageable_id', $image->imageable_id)
                ->where('imageable_type', $image->imageable_type)
                ->where('id', '!=', $image->id)
                ->update(['is_default' => false]);
        }

    }
}
