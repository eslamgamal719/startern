<?php

namespace App\Listeners;

use App\Events\VideoViewer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class IncreaseCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VideoViewer $event)
    {
        $video = $event -> video;
           //if(session()->has('videoIsVisited') 
        if(!Session::has('videoIsVisited_' . $video->id)) {
            $this->updateViewer($event -> video);
        }

        
    }


    public function updateViewer($video) {
        $video->viewer = $video->viewer + 1;
        $video->save();

        session()-> put('videoIsVisited_' . $video->id, $video->id);
    }

}
