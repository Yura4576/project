<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;


class BlogPostObserver
{
    /**
     * Обработка ПЕРЕД созданием записи.
     *
     * @param BlogPost $blogPost
     */
    public function creating(BlogPost $blogPost)
    {
        /*$this->>setPublishedAt($blogPost);

        $this->setSlug($blogPost);*/
    }

    /**
     *Обработка ПЕРЕД обновлением записи.
     *
     * @param  BlogPost $blogPost
     */
    public function updating(BlogPost $blogPost)
    {
//        $test[] = $blogPost->isDirty();
//        $test[] = $blogPost->isDirty('is_published');
//        $test[] = $blogPost->isDirty('user_id');
//        $test[] = $blogPost->getAttribute('is_published');
//        $test[] = $blogPost->is_published;
//        $test[] = $blogPost->getOriginal('is_published');
//        dd($test);

        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);

    }

    /**
     * Если дата публикации не установлена и происходит установка флага - Опубликовано,
     * то устанавливаем дату публикации на текущую.
     *
     * @param BlogPost $blogPost
     */

    protected function setPublishedAt(BlogPost $blogPost)
    {
       $needSetPublished = empty($blogPost->published_at) && $blogPost->is_published;
       if ($needSetPublished) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     *Если поле слаг пустое, то заполняем его конвертацией заголовка.
     *
     *@param BlogPost $blogPost
     */
    protected function setSlug(BlogPost $blogPost)
    {
        if(empty($blogPost->slug)) {
            $blogPost->slug = \Str::slug($blogPost->title);
        }
    }

    /**
     *Handle the blog post "created" event.
     *
     *@param \App\Models\BlogPost $blogPost
     *
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "updated" event.
     *
     * @param \App\Models\BlogPost $blogPost
     *
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}