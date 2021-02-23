<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DataTables;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Arr;
use App\Traits\ImgaeUpload;
use Auth;

class CategoryController extends Controller
{
    use ImgaeUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if ($request->ajax()) {
            $data = Category::orderBy('id','desc')->get();
            return DataTables::of($data)
                            ->addColumn('action', function($row){
                                $btn='';
                                 if($row->user_id==Auth::id() || Auth::user()->is_admin==1) {
                                    $btn = '<a href= "' . route('admin.category.edit', be64($row->id)) . '" class="btn btn-info btn-xs">Edit</a>&nbsp;';
                                    $btn .= '<a href="#" data-id='.be64($row->id).' class="btn btn-danger btn-xs delete_cat">Delete</a>&nbsp;';
                                } 
                                $btn .= '<a href= "' . route('admin.category.show', be64($row->id)) . '" class="btn btn-warning btn-xs">View</a>&nbsp;';
                                
                                return $btn;
                            })
                            ->addIndexColumn()
                            ->make(true);
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
       $input = $request->all();
        if (isset($input['cat_id'])) 
            $category = Category::find(bd64($request->cat_id));
        else 
            $category = new Category();
        
        //logo image upload
        if (isset($request->logo) && $request->has('logo')) {
                $image = $request->logo;
                $ext = $image->getClientOriginalExtension();
                if (in_array($ext, ["jpg", "gif", "jpeg", "png", "bmp","PNG","JPG","JPEG"])) {
                    $imageName = $this->imageUploder($request->logo,'', 'category');
                    $input["logo"] = $imageName;
                }
        }
        $input = Arr::except($input, ['_token','cat_id']);
        $input['user_id']=Auth::id();
        $category->fill($input)->save();
        return redirect()->route('admin.category.index');
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $category=Category::find(bd64($id));
       return view('admin.category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::find(bd64($id));
        return view('admin.category.create',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getFiles=Category::find(bd64($id));
        if(isset($getFiles)){
            Storage::disk('public')->delete('category/'.$getFiles->logo);
        }
        Category::whereId(bd64($id))->delete();
        return response()->json([ 'status' => '200', 'success' => 'success']);
    }
}
