<?php

namespace App\Traits;

trait HasFormattedTimestamps
{
    /**
     * Get the formatted created_at timestamp.
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * Get the formatted updated_at timestamp.
     *
     * @return string
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }
}
