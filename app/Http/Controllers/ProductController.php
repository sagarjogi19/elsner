<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use DataTables;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Arr;
use App\Traits\ImgaeUpload;
use App\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProductController extends Controller {

     use ImgaeUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Product::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                            ->addColumn('action', function($row) {
                                $btn='';
                                if($row->user_id==Auth::id() || Auth::user()->is_admin==1) {
                                $btn = '<a href= "' . route('admin.products.edit', be64($row->id)) . '" class="btn btn-info btn-xs">Edit</a>&nbsp;';
                                $btn .= '<a href="#" data-id=' . be64($row->id) . ' class="btn btn-danger btn-xs delete_prod">Delete</a>&nbsp;';
                                } 
                                $btn .= '<a href= "' . route('admin.products.show', be64($row->id)) . '" class="btn btn-warning btn-xs">View</a>&nbsp;';
                                return $btn;
                            })
                            ->addIndexColumn()
                            ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(Auth::user()->is_admin==1) 
            $category = Category::all();
        else
            $category = Category::whereUserId(Auth::id())->get();
        return view('admin.product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request) {
        $input = $request->all();
        //dd($request->file('images'));
        if (isset($input['prod_id'])) {
            $prod = Product::find(bd64($input['prod_id']));
        }
        //product image upload
        if (isset($request->image) && $request->has('image')) {
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                if (in_array($ext, ["jpg", "gif", "jpeg", "png", "bmp","PNG","JPG","JPEG"])) {
                    $imageName = $this->imageUploder($request->image,'', 'products');
                    $input["image"] = $imageName;
                }
        }
        $categories=$input["category_id"];
        $input = Arr::except($input, ['_token', 'prod_id','category_id']);
        $input['user_id']=Auth::id();
        if (isset($prod)) {
            $prod->fill($input)->save();
        } else {
            $prod = Product::create($input);
        }
        //Add Product Category
        ProductCategory::where('product_id',$prod->id)->delete();
        foreach($categories as $v){
            $prod->categories()->create([ 'category_id' => $v ]);
        }
        
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if(Auth::user()->is_admin==1) 
            $category = Category::all();
        else
            $category = Category::whereUserId(Auth::id())->get();
        $product= Product::with('categories')->whereId(bd64($id))->first();
        return view('admin.product.show',compact('product','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if(Auth::user()->is_admin==1) 
            $category = Category::all();
        else
            $category = Category::whereUserId(Auth::id())->get();
        $product= Product::with('categories')->whereId(bd64($id))->first();
        return view('admin.product.create',compact('product','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $getFiles=Product::find(bd64($id));
        if(isset($getFiles)){
            Storage::disk('public')->delete('products/'.$getFiles->image);
        }
        Product::whereId(bd64($id))->delete();
        ProductCategory::where('product_id',bd64($id))->delete();
        return response()->json([ 'status' => '200', 'success' => 'success']);
    }

}
