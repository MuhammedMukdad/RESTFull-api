<?php

namespace App\Http\Controllers\Seller;

use Exception;
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProductTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'.ProductTransformer::class)->only(['stor','update']);

        $this->middleware('can:view,seller')->only('index');
        $this->middleware('can:sale,seller')->only('store');
        $this->middleware('can:edit-product,seller')->only('update');
        $this->middleware('can:delete-product,seller')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $prodects=$seller->products;

        return $this->showAll($prodects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $seller)
    {
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'quantity'=>'required|integer|min:1',
            'image'=>'required|image',
        ];

        $this->validate($request,$rules);

        $data=$request->all();

        $data['status']=Product::UNAVAILABLE_PRODUVT;
        $data['image']=$request->image->store('');//firts parameter is the path(I put the path in fillesystem file),
        //the seconde one is the disk but i put the images the default
        $data['seller_id']=$seller->id;

        $prodect=Product::create($data);

        return $this->showOne($prodect);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller,$id)
    {
        $prodect=Product::findOrFail($id);

        $rules=[
            'quantity'=>'integer|min:1',
            'status'=>'in'.Product::UNAVAILABLE_PRODUVT.','.Product::AVAILABLE_PRODUVT,
            'image'=>'image'
        ];

        $this->validate($request,$rules);

        $this->checkSeller($seller,$prodect);

        $prodect->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        if($request->has('status')){
            $prodect->status=$request->status;

            if($prodect->isAvailable()&&$prodect->categories()->count()==0){
                return $this->errorResponse('An active product must have at least one category',409);
            }
        }

        if($request->has('image')){

            Storage::delete($prodect->image);

            $prodect->image=$request->image->store('');
        }

        if($prodect->isClean()){
            return $this->errorResponse('You need to seend defferent values to update',422);
        }
        $prodect->save();

        return $this->showOne($prodect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,$id)
    {
        $prodect=Product::findOrFail($id);

        $this->checkSeller($seller,$prodect);

        $prodect->delete();
        Storage::delete($prodect->image);//this param is from public but I specify the default .

        return $this->showOne($prodect);
    }

    protected function checkSeller(Seller $seller,Product $prodect){

        if($seller->id != $prodect->seller_id){
            throw new HttpException(422,"this seller is not sell this product");
        }

    }
}
