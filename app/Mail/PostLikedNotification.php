<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostLikedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $post;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     */
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your post has been liked!')
            ->view('emails.postLiked')
            ->with([
                'userName' => $this->user->name,
                'postContent' => $this->post->content,
            ]);
    }
}
