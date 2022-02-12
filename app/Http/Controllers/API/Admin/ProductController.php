<?php

namespace App\Http\Controllers\API\Admin;

use Ramsey\Uuid\Uuid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    public function getProduct(){
        $product = Product::orderBy('created_at','DESC')->paginate();
        return response()->json([
            'header' => [
                'code' => 200,
                'message' => 'Success'
            ],
            'data' => $product
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'quantity' => 'required|numeric',
        ]);

        try{
            DB::beginTransaction();
            $product = Product::create([
                'uuid' => Uuid::uuid4()->toString(),
                'name' => $request->name,
                'price' => $request->price,
                'type' => $request->type,
                'quantity' => $request->quantity,
            ]);
            DB::commit();
            return response()->json([
                'header' => [
                    'code' => 200,
                    'message' => 'Success'
                ],
                'data' => $product
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function Delete($id){
        try{
            DB::beginTransaction();
            $product = Product::where('uuid',$id)->first();
            $product->delete();
            DB::commit();
            return response()->json([
                'header' => [
                    'code' => 200,
                    'message' => 'Success delete product'
                ],
                'data' => $product
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function Detail($id){
        try{
            $product = Product::where('uuid',$id)->first();
            return response()->json([
                'header' => [
                    'code' => 200,
                    'message' => 'Success get product by uuid'
                ],
                'data' => $product
            ]);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function Update(Request $request,$id){
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'quantity' => 'required|numeric',
        ]);

        try{
            DB::beginTransaction();
            $product = Product::where('uuid',$id)->first();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->type = $request->type;
            $product->quantity = $request->quantity;
            $product->save();
            DB::commit();
            return response()->json([
                'header' => [
                    'code' => 200,
                    'message' => 'Success update product'
                ],
                'data' => $product
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
