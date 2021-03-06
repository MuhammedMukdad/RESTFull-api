<?php

namespace App\Traits;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

trait ApiResponser
{
    private function successResponse($data,$code){
        return response()->json($data,$code);
    }
    protected function errorResponse($message,$code){
        return response()->json(['error'=>$message,'code'=>$code],$code);
    }

    protected function showAll(Collection $collection,$code=200){
        if($collection->isEmpty()){
            return $this->successResponse(['data'=>$collection],$code);
        }

        $transformer=$collection->first()->transformer;

        $collection=$this->filterData($collection,$transformer);
        $collection=$this->sortData($collection,$transformer);
        $collection=$this->paginate($collection);
        $collection= $this->transformeData($collection,$transformer);
        $collection= $this->cacheResponse($collection);

        return $this->successResponse($collection,$code);
    }

    protected function showOne(Model $model,$code=200){
        $transformer=$model->transformer;

        $model=$this->transformeData($model,$transformer);

        return $this->successResponse($model,$code);
    }

    protected function showMessage($message,$code=200){
        return $this->successResponse(['data'=>$message],$code);
    }

    protected function filterData(Collection $collection,$transformer){

        foreach (request()->query() as $query => $value) {
            $atrr=$transformer::realAttr($query);
            if(isset($atrr,$value)){
                echo "asd";
                $collection=$collection->where($atrr,$value);
            }
        }
        return $collection;
    }

    protected function sortData(Collection $collection,$transformer){
        if(request()->has('sort_by')){
            $attr=$transformer::realAttr(request()->sort_by);
            $collection=$collection->sortBy->{$attr};
        }
        return $collection;
    }

   protected function paginate(Collection $collection){

    $rules=[
        'per_page'=>'integer|min:2|max:50'
    ];

    Validator::validate(request()->all(),$rules);

    $page=LengthAwarePaginator::resolveCurrentPage();

       $perPage=15;

       if(request()->has('per_page')){
           $perPage=(int)request()->per_page;
       }

       $results=$collection->slice(($page-1)* $perPage,$perPage)->values();

       $paginated=new LengthAwarePaginator($results,$collection->count(),$perPage,$page,[
           'path'=>LengthAwarePaginator::resolveCurrentPath(),
       ]);

       $paginated->appends(request()->all());

       return $paginated;
   }

    protected function transformeData($data,$transformer){
        
        $transformation=fractal($data,new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data){

        $url=request()->url();
        $queryParam=request()->query();

        ksort($queryParam);

        $queryString=http_build_query($queryParam);

        $fullUrl="{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function () use($data,$url){

            return $data;
        });
    }
}
