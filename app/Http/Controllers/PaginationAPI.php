<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\Articles;
//use illuminate\http\request;
//
//class PaginationAPI
//{
//    public function Pagination_API(Request $request){
//        if(isset($_GET['search'])) {
//            $results = Articles::query()->where(('ab_name'),'ILIKE', '%'.strtolower($_GET['search']).'%')->get();
//        }else{
//            $limit = 5;
//            $offset = $_GET['page']-1 ?? 0;
//            $offset = $offset *$limit;
//            $results = Articles::query()->orderBy('id')->offset($offset)->limit($limit)->get();
//        }
//        foreach ($results as $result) {
//            $result->image_url = asset($this->getImagePath($result->id));
//        }
//        return response()->json($results, 200);
//    }
//
//    public function getPageCount_api(Request $request){
//        $limit = 20;
//        $datacount = Articles::query()->count();
//        $data = array();
//        for($i=1;$i<=ceil($datacount/$limit);$i++){
//            $data[$i-1]=$i;
//        }
//        $data = json_encode($data);
//        return response($data);
//    }
//
//    public function getImagePath($id)
//    {
//        $jpgImagePath = "/img/{$id}.jpg";
//        $pngImagePath = "/img/{$id}.png";
//
//        if (file_exists(public_path($jpgImagePath))) {
//            return $jpgImagePath;
//        } elseif (file_exists(public_path($pngImagePath))) {
//            return $pngImagePath;
//        }
//
//        return "/img/default.png";
//    }
//}
