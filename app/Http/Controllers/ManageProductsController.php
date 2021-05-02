<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\ComparisionGroup;
use App\Http\Requests\ProductsCreateRequest;
use App\Http\Requests\ProductsUpdateRequest;
use App\Location;
use App\Photo;
use App\Product;
use App\Other;
use App\Vendor;
use App\SpecificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ManageProductsController extends Controller
{
    public function index()
    {
        $vendor = Auth::user()->isApprovedVendor();
        $products_vendor = null;
        if(Auth::user()->can('read', Product::class) || $vendor) {
            if($vendor) {
                $products = Product::where('location_id', Auth::user()->location_id)->where('vendor_id', $vendor->id);
            } else {
                if(request()->has('stock') && request()->stock == 'low') {
                    $products = Product::where('location_id', Auth::user()->location_id)->where('in_stock', '<=', 10)->where('in_stock', '>=', 1);
                } else if(request()->has('vendor') && request()->vendor) {
                    $vendor_id = request()->vendor;
                    $products_vendor = Vendor::select('id', 'name')->whereId($vendor_id)->firstOrFail();
                    $products = Product::where('location_id', Auth::user()->location_id)->where('vendor_id', $vendor_id);
                } else if(request()->has('stock') && request()->stock == 'none') {
                    $products = Product::where('location_id', Auth::user()->location_id)->where('in_stock', '<', 1);
                } else {
                    $products = Product::where('location_id', Auth::user()->location_id);
                }
            }

            /* Search */
            if(!empty(request()->s)) {
                $search = request()->s;
                $products = $products->where('name', 'LIKE', "%$search%")
                ->orWhereHas('brand', function($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                })->orWhereHas('category', function($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                })->orWhere('sku', "$search");
            }

            /* Ordering */
            $products = $products->orderBy('id', 'desc');

            /* Pagination */
            if(empty(request()->all)) {
                if(!empty(request()->per_page)) {
                    $per_page = intval(request()->per_page);
                } else {
                    $per_page = 15;
                }
            } else {
                $per_page = $products->count();
            }
            $products = $products->paginate($per_page);

            return view('manage.products.index', compact('products', 'vendor', 'products_vendor'));
        } else {
            return view('errors.403');
        }
    }

    public function sales()
    {
        if(Auth::user()->can('viewSales', Other::class)) {
            $vendor = Auth::user()->isApprovedVendor();
            if ($vendor){
                $sales = Product::select('id', 'name', 'sales', 'price', 'photo_id', 'location_id')->where('vendor_id', $vendor->id)->where('location_id', Auth::user()->location_id)->orderBy('id', 'desc')->get();
            }else{
                $sales = Product::where('location_id', Auth::user()->location_id)->select('id', 'name', 'sales', 'price', 'photo_id', 'location_id')->orderBy('id', 'desc')->get();
            }
            return view('manage.sales.sales', compact('sales'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('create', Product::class) || $vendor) {
            $location_id = Auth::user()->location_id;
            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            $comparision_groups = ComparisionGroup::all();
            $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            $specification_types = SpecificationType::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            if($vendor) {
                $products = Product::select('id', 'name')->where('location_id', $location_id)->where('vendor_id', $vendor->id)->get();
            } else {
                $products = Product::select('id', 'name')->where('location_id', $location_id)->get();
            }
            return view('manage.products.create', compact('root_categories', 'brands', 'specification_types', 'products', 'vendor', 'comparision_groups'));

        } else {
            return view('errors.403');
        }
    }

    public function store(ProductsCreateRequest $request)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('create', Product::class) || $vendor) {
            $userInput = $request->all();

            $this->validate($request, [
                'photos.*' => 'image'
            ]);

            $input["name"] = $userInput["name"];
            $input["description"] = $userInput["description"];
            $input["sku"] = trim($userInput["sku"]) ? trim($userInput["sku"]) : NULL;
            $input["hsn"] = trim($userInput["hsn"]) ? trim($userInput["hsn"]) : NULL;
            $input["model"] = $userInput["model"];
            $input["price"] = $userInput["price"];
            $input["old_price"] = $request->regular_price ? $request->regular_price : null;
            $input["tax_rate"] = $userInput["tax_rate"];
            if($request->specification_type) {
                $input["specification_type"] = $userInput["specification_type"];
                $input["specification_type_value"] = $userInput["specification_type_value"];
                $input["specification_type_unit"] = $userInput["specification_type_unit"];
            }
            if($request->custom_field_name) {
                $input["custom_field_name"] = $userInput["custom_field_name"];
                $input["custom_field_value"] = $userInput["custom_field_value"];
            }
            $input["in_stock"] = $userInput["in_stock"];
            $input["qty_per_order"] = $userInput["qty_per_order"];
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            $variants = [];
            if(is_array($request->variant) && count($request->variant) > 0) {
                foreach($request->variant as $key => $value) {
                    $variant_value_price = [];

                    foreach($request->variant_v[$key] as $variant_index => $variant_value) {

                        array_push($variant_value_price,
                            [
                                'n' => $variant_value,
                                'p' => ($request->variant_p)[$key][$variant_index]
                            ]
                        );
                    }

                    $variant_data = [
                        'n' => $value,
                        'c' => ($request->is_color)[$key],
                        'v' => $variant_value_price
                    ];

                    array_push($variants, $variant_data);
                }
            }

            $input["variants"] = serialize($variants);

            $input['user_id'] = Auth::user()->id;
    
            $brands = Brand::pluck('name','id')->all();
            $categories = Category::pluck('name','id')->all();
            $comparision_groups = ComparisionGroup::pluck('title','cg_id')->all();

            if($vendor) {
                $input['vendor_id'] = $vendor->id;
                if($sku = $input['sku']) {
                    $input['sku'] = "{$input['vendor_id']}-$sku";
                }
                if($hsn = $input['hsn']) {
                    $input['hsn'] = "{$input['vendor_id']}-$hsn";
                }
            }

            if($input['sku']) {
                $product_exists = Product::select('id')->where('sku', $input['sku'])->count();
                if($product_exists) {
                    return redirect()->back()->withErrors(['sku' => __('SKU already exists.')])->withInput($request->input());
                }
            }

            if(array_key_exists($request->brand, $brands)) {
                $input['brand_id'] = $request->brand;
            } else {
                $input['brand_id'] = NULL;
            }
    
            if(array_key_exists($request->category, $categories)) {
                $input['category_id'] = $request->category;
            } else {
                $input['category_id'] = NULL;
            }

            if(array_key_exists($request->comp_group, $comparision_groups)) {
                $input['comp_group_id'] = $request->comp_group;
            } else {
                $input['comp_group_id'] = NULL;
            }

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            $input['barcode'] = time();

            if($file = $request->file('file')) {
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getFilename().time().'.'.$extension;
                Storage::disk('local')->put($filename,  File::get($file));
                $entry = new \App\File();
                $entry->mime = $file->getClientMimeType();
                $entry->original_filename = $file->getClientOriginalName();
                $entry->filename = $filename;
                $entry->save();
                $input['file_id'] = $entry->id;
            }

            if($request->virtual) {
                $input['qty_per_order'] = 1;
                $input['in_stock'] = 999;
                $input['virtual'] = true;
            }

            if($request->downloadable) {
                $input['downloadable'] = true;
            }

            $customFieldData = [];
            if(array_key_exists('custom_field_name', $input)) {
                foreach($input['custom_field_name'] as $key => $custom_field) {
                    $customFieldData[$custom_field] = $input['custom_field_value'][$key];
                }
            }
            $customFieldData = serialize($customFieldData);
            $input['custom_fields'] = $customFieldData;

            $product = new Product($input);
            $product->save();

            if(array_key_exists('product', $userInput)) {
                $product->related_products()->sync($userInput['product']);
            }

            $specificationData = [];
            if(array_key_exists('specification_type', $input)) {
                foreach($input['specification_type'] as $key=>$type) {

                    $specificationData[$type] = 
                        [
                            'value'=>$input['specification_type_value'][$key],
                            'unit'=>$input['specification_type_unit'][$key]
                        ];
                }
            }

            $product->specificationTypes()
                ->sync($specificationData);

            if($request->file('photos') && count($request->file('photos')) > 0) {
                foreach($request->file('photos') as $photo) {
                    $name = 'alt_img_'.time().$photo->getClientOriginalName();
                    $photo->move(Photo::getPhotoDirectoryName(), $name);
                    $product->photos()->create(['name' => $name]);
                }
            }

            session()->flash('product_created', __("New product has been added."));
            session()->flash('product_view', $product->slug);
            return redirect(route('manage.products.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('update', Product::class) || $vendor) {
            $location_id = Auth::user()->location_id;
            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            $comparision_groups = ComparisionGroup::all();
            $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            $specification_types = SpecificationType::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            $vendor_prefix = '';
            if($vendor) {
                $product = Product::where('location_id', $location_id)->where('id', $id)->where('vendor_id', $vendor->id)->firstOrFail();
                $products = Product::select('id', 'name')->whereNotIn('id', [$id])->where('location_id', $location_id)->where('vendor_id', $vendor->id)->get();

                $sku = $product->sku;
                $hsn = $product->hsn;

                if($sku) {
                    $last_space = strpos($product->sku, '-');
                    $sku = substr($product->sku, $last_space + 1);
                }
                if($hsn) {
                    $last_space = strpos($product->hsn, '-');
                    $hsn = substr($product->hsn, $last_space + 1);
                }
            } else {
                $product = Product::where('location_id', $location_id)->where('id', $id)->firstOrFail();
                $products = Product::select('id', 'name')->whereNotIn('id', [$id])->where('location_id', $location_id)->get();

                $sku = $product->sku;
                $hsn = $product->hsn;

                if($product->vendor) {
                    $vendor_prefix = $product->vendor->id;
                    if($sku) {
                        $last_space = strpos($product->sku, '-');
                        $sku = substr($product->sku, $last_space + 1);
                    }
                    if($hsn) {
                        $last_space = strpos($product->hsn, '-');
                        $hsn = substr($product->hsn, $last_space + 1);
                    }
                }
            }

            $variants = unserialize($product->variants);
            if(!is_array($variants)) {
                $variants = [];
            }

            return view('manage.products.edit', compact('variants', 'product', 'root_categories', 'brands', 'specification_types', 'products', 'vendor', 'sku', 'hsn', 'vendor_prefix', 'comparision_groups'));
        } else {
            return view('errors.403');
        }
    }

    public function update(ProductsUpdateRequest $request, $id)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('update', Product::class) || $vendor) {
            if($vendor) {
                $product = Product::where('vendor_id', $vendor->id)->where('id', $id)->firstOrFail();
            } else {
                $product = Product::findOrFail($id);
            }

            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["description"] = $userInput["description"];
            $input["sku"] = trim($userInput["sku"]) ? trim($userInput["sku"]) : NULL;
            $input["hsn"] = trim($userInput["hsn"]) ? trim($userInput["hsn"]) : NULL;
            $input["model"] = $userInput["model"];
            $input["price"] = $userInput["price"];
            $input["old_price"] = $request->regular_price ? $request->regular_price : null;
            $input["tax_rate"] = $userInput["tax_rate"];
            if($request->specification_type) {
                $input["specification_type"] = $userInput["specification_type"];
                $input["specification_type_value"] = $userInput["specification_type_value"];
                $input["specification_type_unit"] = $userInput["specification_type_unit"];
            }
            if($request->custom_field_name) {
                $input["custom_field_name"] = $userInput["custom_field_name"];
                $input["custom_field_value"] = $userInput["custom_field_value"];
            }            
            $input["in_stock"] = $userInput["in_stock"];
            $input["qty_per_order"] = $userInput["qty_per_order"];
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            $variants = [];
            if(is_array($request->variant) && count($request->variant) > 0) {
                foreach($request->variant as $key => $value) {
                    $variant_value_price = [];

                    foreach($request->variant_v[$key] as $variant_index => $variant_value) {

                        array_push($variant_value_price,
                            [
                                'n' => $variant_value,
                                'p' => ($request->variant_p)[$key][$variant_index]
                            ]
                        );
                    }

                    $variant_data = [
                        'n' => $value,
                        'c' => ($request->is_color)[$key],
                        'v' => $variant_value_price
                    ];

                    array_push($variants, $variant_data);
                }
            }

            $input["variants"] = serialize($variants);

            $brands = Brand::pluck('name','id')->all();
            $categories = Category::pluck('name','id')->all();
            $comparision_groups = ComparisionGroup::pluck('title','cg_id')->all();

            if($product->vendor) {
                $input['vendor_id'] = $product->vendor->id;
                if($sku = $input['sku']) {
                    $input['sku'] = "{$product->vendor->id}-$sku";
                }
                if($hsn = $input['hsn']) {
                    $input['hsn'] = "{$product->vendor->id}-$hsn";
                }
            }

            if($input['sku']) {
                $product_exists = Product::select('id')->where('id', '!=', $product->id)->where('sku', $input['sku'])->count();
                if($product_exists) {
                    return redirect()->back()->withErrors(['sku' => __('SKU already exists.')])->withInput($request->input());
                }
            }

            if(array_key_exists($request->brand, $brands)) {
                $input['brand_id'] = $request->brand;
            } else {
                $input['brand_id'] = NULL;
            }

            if($request->remove_category) {
                $input['category_id'] = NULL;
            } else {
                if(array_key_exists($request->category, $categories)) {
                    $input['category_id'] = $request->category;
                } else {
                    $input['category_id'] = $product->category_id;
                }
            }

            if(array_key_exists($request->comp_group, $comparision_groups)) {
                $input['comp_group_id'] = $request->comp_group;
            } else {
                $input['comp_group_id'] = NULL;
            }

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            if(!$request->file('photo') && $request->remove_photo) {
                if($product->photo) {
                    if(file_exists($product->photo->getPath())) {
                        unlink($product->photo->getPath());
                        $product->photo()->delete();
                    }
                }
            }

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                if($product->photo) {
                    if(file_exists($product->photo->getPath())) {
                        unlink($product->photo->getPath());
                        $product->photo()->delete();
                    }
                }
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            if(!$request->file('file') && $request->remove_file) {
                if($product->file) {
                    Storage::disk('local')->delete($product->file->filename);
                    $product->file()->delete();
                    $input['file_id'] = NULL;
                    $input['downloadable'] = false;
                    $input['virtual'] = false;
                }
            }

            if($file = $request->file('file')) {
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getFilename().time().'.'.$extension;
                Storage::disk('local')->put($filename,  File::get($file));
                $entry = new \App\File();
                $entry->mime = $file->getClientMimeType();
                $entry->original_filename = $file->getClientOriginalName();
                $entry->filename = $filename;
                $entry->save();
                $input['file_id'] = $entry->id;
                if($product->file) {
                    Storage::disk('local')->delete($product->file->filename);
                    $product->file()->delete();
                }
            }

            if($request->remove_images) {
                foreach($product->photos as $photo) {
                    if(in_array($photo->id, $request->remove_images)) {
                        if(file_exists($photo->getPath())) {
                            unlink($photo->getPath());
                            $photo->delete();
                        }
                    }
                }
            }

            if($request->virtual) {
                $input['qty_per_order'] = 1;
                $input['in_stock'] = 999;
                $input['virtual'] = true;
            }

            if($request->downloadable) {
                $input['downloadable'] = true;
            }

            $customFieldData = [];
            if(array_key_exists('custom_field_name', $input)) {
                foreach($input['custom_field_name'] as $key => $custom_field) {
                    $customFieldData[$custom_field] = $input['custom_field_value'][$key];
                }
            }
            $customFieldData = serialize($customFieldData);
            $input['custom_fields'] = $customFieldData;

            if(array_key_exists('product', $userInput)) {
                $product->related_products()->sync($userInput['product']);
            } else {
                $product->related_products()->sync([]);
            }

            $product->update($input);

            if(array_key_exists('specification_type', $input)) {
                $specificationData = [];
                foreach($input['specification_type'] as $key=>$type) {

                    $specificationData[$type] = 
                        [
                            'value'=>$input['specification_type_value'][$key],
                            'unit'=>$input['specification_type_unit'][$key]
                        ];
                }

                $product->specificationTypes()
                    ->sync($specificationData);
            }

            session()->flash('product_updated', __("The product has been updated."));
            return redirect(route('manage.products.edit', $product->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('delete', Product::class) || $vendor) {
            if($vendor) {
                $product = Product::where('vendor_id', $vendor->id)->where('id', $id)->firstOrFail();
            } else {
                $product = Product::findOrFail($id);
            }

            if($product->orders->count()) {
                session()->flash('product_not_deleted', __("This product is currently in orders."));
                return redirect(route('manage.products.index'));
            }
            if($product->photo) {
                if(file_exists($product->photo->getPath())) {
                    unlink($product->photo->getPath());
                    $product->photo()->delete();
                }
            }

            if($product->file) {
                Storage::disk('local')->delete($product->file->filename);
                $product->file()->delete();
            }

            foreach($product->photos as $photo) {
                if(file_exists($photo->getPath())) {
                    unlink($photo->getPath());
                    $photo->delete();
                }
            }
            $product->specificationTypes()->detach();
            $product->sales()->delete();
            $product->delete();
            session()->flash('product_deleted', __("The product has been deleted."));
            return redirect(route('manage.products.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteProducts(Request $request)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('delete', Product::class) || $vendor) {
            if(isset($request->delete_single)) {
                if($vendor) {
                    $product = Product::where('vendor_id', $vendor->id)->firstOrFail($request->delete_single);
                } else {
                    $product = Product::findOrFail($request->delete_single);
                }
                if($product->orders->count()) {
                    session()->flash('product_not_deleted', __("This product is currently in orders."));
                    return redirect(route('manage.products.index'));
                }
                if($product->photo) {
                    if(file_exists($product->photo->getPath())) {
                        unlink($product->photo->getPath());
                        $product->photo()->delete();
                    }
                }

                if($product->file) {
                    Storage::disk('local')->delete($product->file->filename);
                    $product->file()->delete();
                }

                foreach($product->photos as $photo) {
                    if(file_exists($photo->getPath())) {
                        unlink($photo->getPath());
                        $photo->delete();
                    }
                }
                $product->specificationTypes()->detach();
                $product->sales()->delete();
                $product->delete();
                session()->flash('product_deleted', __("The product has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    if($vendor) {
                        $vendor_product_ids = $vendor->products()->pluck('id')->toArray();
                        if(!(count(array_intersect($request->checkboxArray, $vendor_product_ids)) == count($request->checkboxArray))) {
                            session()->flash('product_not_deleted', "Invalid product selection.");
                            return redirect(route('manage.products.index'));
                        }
                    }
                    $products = Product::findOrFail($request->checkboxArray);
                    foreach($products as $product) {
                        if($product->orders->count()) {
                            session()->flash('product_not_deleted', __("The products are currently in orders."));
                            return redirect(route('manage.products.index'));
                        }
                    }
                    foreach($products as $product) {
                        if($product->photo) {
                            if(file_exists($product->photo->getPath())) {
                                unlink($product->photo->getPath());
                                $product->photo()->delete();
                            }
                        }

                        if($product->file) {
                            Storage::disk('local')->delete($product->file->filename);
                            $product->file()->delete();
                        }

                        foreach($product->photos as $photo) {
                            if(file_exists($photo->getPath())) {
                                unlink($photo->getPath());
                                $photo->delete();
                            }
                        }
                        $product->specificationTypes()->detach();
                        $product->sales()->delete();
                        $product->delete();
                    }
                    session()->flash('product_deleted', __("The selected products have been deleted."));
                } else {
                    session()->flash('product_not_deleted', __("Please select products to be deleted."));
                }
            }
            return redirect(route('manage.products.index'));
        } else {
            return view('errors.403');
        }
    }

    public function storeMoreImages(Request $request, $id)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('update', Product::class) || $vendor) {
            $this->validate($request, [
                'file' => 'image'
            ]);

            if($photo = $request->file('file')) {
                if($vendor) {
                    $product = Product::where('vendor_id', $vendor->id)->where('id', $id)->firstOrFail();
                } else {
                    $product = Product::findOrFail($id);
                }
                $name = 'alt_img_'.time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                $product->photos()->create(['name' => $name]);
            }
        } else {
            return view('errors.403');
        }
    }

    public function download($filename)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('update', Product::class) || $vendor) {

            $file = \App\File::where('filename', $filename)->first();

            if($vendor && $file->product->vendor_id != $vendor->id) {
                return view('errors.403');
            }

            if($file->product->location_id != Auth::user()->location_id) {
                return view('errors.403');
            }

            try {
                $pathToFile = storage_path('app/' . $file->filename);
                $headers = array(
                    'Content-Type' => 'application/pdf',
                );
                return response()->download($pathToFile, $file->original_filename, $headers);
            } catch (\Exception $e) {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function getExistingProduct($id)
    {
        $vendor = Auth::user()->isApprovedVendor();
        if(Auth::user()->can('create', Product::class) || $vendor) {
            if(\Illuminate\Support\Facades\Request::ajax()) {
                $location_id = Auth::user()->location_id;

                if($vendor) {
                    $product = Product::where('location_id', $location_id)->where('vendor_id', $vendor->id)->whereId($id)->first();
                    $products = Product::select('id', 'name')->where('location_id', $location_id)->where('vendor_id', $vendor->id)->get();
                } else {
                    $product = Product::where('location_id', $location_id)->whereId($id)->first();
                    $products = Product::select('id', 'name')->where('location_id', $location_id)->get();
                }

                $sku = $product->sku;
                $hsn = $product->hsn;

                if($product->vendor) {
                    if($sku) {
                        $last_space = strpos($product->sku, '-');
                        $sku = substr($product->sku, $last_space + 1);
                    }
                    if($hsn) {
                        $last_space = strpos($product->hsn, '-');
                        $hsn = substr($product->hsn, $last_space + 1);
                    }
                }

                $variants = unserialize($product->variants);
                if(!is_array($variants)) {
                    $variants = [];
                }

                $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
                $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
                $specification_types = SpecificationType::where('location_id', $location_id)->pluck('name', 'id')->toArray();

                return response()->view('partials.manage.existing-product', compact('variants', 'product', 'root_categories', 'brands', 'specification_types', 'products', 'sku', 'hsn'), 200);
            }
        } else {
            return view('errors.403');
        }
    }
}
