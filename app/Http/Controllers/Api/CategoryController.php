<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if($request->has('orderBy')) {
            $filter = explode(',', $request->orderBy);
            $column = $filter[0];
            $sortDirection = $filter[1];
            $tableName = with(new Category)->getTable();
            if(Schema::hasColumn($tableName, $column)) {
                $query->orderBy($column, $sortDirection);
            }
        }

        if($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%')
            ->get();
        }
        
        return $query->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());

        return response()->json(
            [
                "message" => "Categoria criada com sucesso",
                "id" => $category->id
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(
                ['message' => 'Registro não encontrado'],
                404
            );
        }

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(
                ['message' => 'Registro não encontrado'],
                404
            );
        }

        $category->fill($request->all());
        $category->save();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $categoryId, Authenticatable $user)
    {
        if($user->tokenCan('delete')) {
            $category = Category::find($categoryId);
        
            if (!$category) {
                return response()->json(
                    ['message' => 'Registro não encontrado'],
                    404
                );
            }
    
            $category->delete($categoryId);
    
            return response()->noContent();
        } else {
            return response()->json(
                ['message' => 'Token sem permissão para efetuar a exclusão'],
                401
            );
        }
    }
}
