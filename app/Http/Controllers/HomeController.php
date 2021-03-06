<?php

namespace App\Http\Controllers;

use App\Album;
use App\Announcement;
use App\Article;
use App\Book;
use App\Category;
use App\History;
use App\Link;
use App\Question;
use App\Slide;
use App\Song;
use App\Stream;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories=Category::all();
        $albums=Album::all();
        $songs=Song::all();
        $books=Book::all();
        $links=Link::all();
        $articles=Article::all();
        $streams=Stream::all();
        $questions=Question::all();
        $slides=Slide::all();
        $histories=History::all();
        $announcements=Announcement::all();

        return view('home')->with(['categories'=>$categories,'albums'=>$albums,'songs'=>$songs,'books'=>$books,'links'=>$links,'articles'=>$articles,'streams'=>$streams,'questions'=>$questions,'histories'=>$histories,'slides'=>$slides,'announcements'=>$announcements, ]);
    }
}
