<?php

namespace App\Listeners;

use App\Events\PostLiked;
use App\Mail\PostLikedNotification;
use Illuminate\Support\Facades\Mail;

class SendPostLikedNotification
{
    public function handle(PostLiked $event)
    {
        $postOwner = $event->post->user;

        Mail::to($postOwner->email)->send(new PostLikedNotification($event->user, $event->post));
    }
}
