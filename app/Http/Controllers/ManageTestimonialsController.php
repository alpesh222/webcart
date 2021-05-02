<?php

namespace App\Http\Controllers;

use App\Testimonial;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\TestimonialsCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManageTestimonialsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Testimonial::class)) {
            $testimonials = Testimonial::all();
            return view('manage.testimonials.index', compact('testimonials'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', Testimonial::class)) {
            return view('manage.testimonials.create');

        } else {
            return view('errors.403');
        }
    }

    public function store(TestimonialsCreateRequest $request)
    {
        if(Auth::user()->can('create', Testimonial::class)) {
            $userInput = $request->all();
            $input["author"] = $userInput["author"];
            $input["designation"] = $request->designation ? $request->designation : '';
            $input["review"] = $userInput["review"];
            $input["priority"] = $userInput["priority"];

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            $testimonial = new Testimonial($input);
            $testimonial->save();

            session()->flash('testimonial_created', __("New testimonial has been added."));
            return redirect(route('manage.testimonials.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Testimonial::class)) {
            $testimonial = Testimonial::where('id', $id)->firstOrFail();
            return view('manage.testimonials.edit', compact('testimonial'));
        } else {
            return view('errors.403');
        }
    }

    public function update(TestimonialsCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Testimonial::class)) {
            $testimonial = Testimonial::findOrFail($id);
            $userInput = $request->all();
            $input["author"] = $userInput["author"];
            $input["designation"] = $request->designation ? $request->designation : '';
            $input["review"] = $userInput["review"];
            $input["priority"] = $userInput["priority"];

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            if(!$request->file('photo') && $request->remove_photo) {
                if($testimonial->photo) {
                    if(file_exists($testimonial->photo->getPath())) {
                        unlink($testimonial->photo->getPath());
                        $testimonial->photo()->delete();
                    }
                }
            }

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                if($testimonial->photo) {
                    if(file_exists($testimonial->photo->getPath())) {
                        unlink($testimonial->photo->getPath());
                        $testimonial->photo()->delete();
                    }
                }
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            $testimonial->update($input);

            session()->flash('testimonial_updated', __("The testimonial has been updated."));
            return redirect(route('manage.testimonials.edit', $testimonial->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Testimonial::class)) {
            $testimonial = Testimonial::findOrFail($id);
            if($testimonial->photo) {
                if(file_exists($testimonial->photo->getPath())) {
                    unlink($testimonial->photo->getPath());
                    $testimonial->photo()->delete();
                }
            }
            $testimonial->delete();
            session()->flash('testimonial_deleted', __("The testimonial has been deleted."));
            return redirect(route('manage.testimonials.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteTestimonials(Request $request)
    {
        if(Auth::user()->can('delete', Testimonial::class)) {
            if(isset($request->delete_single)) {
                $testimonial = Testimonial::findOrFail($request->delete_single);
                if($testimonial->photo) {
                    if(file_exists($testimonial->photo->getPath())) {
                        unlink($testimonial->photo->getPath());
                        $testimonial->photo()->delete();
                    }
                }
                $testimonial->delete();
                session()->flash('testimonial_deleted', __("The testimonial has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $testimonials = Testimonial::findOrFail($request->checkboxArray);
                    foreach($testimonials as $testimonial) {
                        if($testimonial->photo) {
                            if(file_exists($testimonial->photo->getPath())) {
                                unlink($testimonial->photo->getPath());
                                $testimonial->photo()->delete();
                            }
                        }
                        $testimonial->delete();
                    }
                    session()->flash('testimonial_deleted', __("The selected testimonials have been deleted."));
                } else {
                    session()->flash('testimonial_not_deleted', __("Please select testimonials to be deleted."));
                }
            }
            return redirect(route('manage.testimonials.index'));
        } else {
            return view('errors.403');
        }
    }
}