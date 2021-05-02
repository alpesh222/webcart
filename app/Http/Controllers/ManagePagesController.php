<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Requests\PagesCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManagePagesController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Page::class)) {
            $pages = Page::all();
            return view('manage.pages.index', compact('pages'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', Page::class)) {
            return view('manage.pages.create');

        } else {
            return view('errors.403');
        }
    }

    public function store(PagesCreateRequest $request)
    {
        if(Auth::user()->can('create', Page::class)) {
            $userInput = $request->all();
            $input["title"] = $userInput["title"];
            $input["content"] = $userInput["content"];
            $input["priority"] = $userInput["priority"];
            $input["show_in_menu"] = $request->show_in_menu ? true : false;
            $input["show_in_footer"] = $request->show_in_footer ? true : false;
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            $page = new Page($input);
            $page->save();

            session()->flash('page_created', __("New page has been added."));
            session()->flash('page_view', $page->slug);
            return redirect(route('manage.pages.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Page::class)) {
            $page = Page::where('id', $id)->firstOrFail();
            return view('manage.pages.edit', compact('page'));
        } else {
            return view('errors.403');
        }
    }

    public function update(PagesCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Page::class)) {
            $page = Page::findOrFail($id);
            $userInput = $request->all();
            $input["title"] = $userInput["title"];
            $input["content"] = $userInput["content"];
            $input["priority"] = $userInput["priority"];
            $input["show_in_menu"] = $request->show_in_menu ? true : false;
            $input["show_in_footer"] = $request->show_in_footer ? true : false;
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            $page->update($input);

            session()->flash('page_updated', __("The page has been updated."));
            return redirect(route('manage.pages.edit', $page->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Page::class)) {
            $page = Page::findOrFail($id);
            $page->delete();
            session()->flash('page_deleted', __("The page has been deleted."));
            return redirect(route('manage.pages.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deletePages(Request $request)
    {
        if(Auth::user()->can('delete', Page::class)) {
            if(isset($request->delete_single)) {
                $page = Page::findOrFail($request->delete_single);
                $page->delete();
                session()->flash('page_deleted', __("The page has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $pages = Page::findOrFail($request->checkboxArray);
                    foreach($pages as $page) {
                        $page->delete();
                    }
                    session()->flash('page_deleted', __("The selected pages have been deleted."));
                } else {
                    session()->flash('page_not_deleted', __("Please select pages to be deleted."));
                }
            }
            return redirect(route('manage.pages.index'));
        } else {
            return view('errors.403');
        }
    }
}
