<?php

namespace App\Http\Controllers;

use App\Place;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use DB;
class PlaceController extends Controller
{
  public function create(Request $request)
  {
    $this->validate($request, [
      'Name'  => 'required',
      'Comments' => 'required',
      'Type'  => 'required',
      'IsActive' => 'required',
    ]);

    $post = new Place;
    $post->Name = $request->input('Name');
    $post->Comments = $request->input('Comments');
    $post->Type = $request->input('Type');
    $post->IsActive = $request->input('IsActive');
    $post->CreatedBy= Auth::user()->id;
    $post->save();

    return response()->success(compact('post'));
  } 

  public function getIndex(Request $request)
  {


    $draw = $request->input('draw');
    $start =$request->input('start');
    $length =$request->input('length');



    $countplaces = Place::whereNull('DeletedBy')->where('IsArchive',0)->count();

    $places = Place::whereNull('DeletedBy')
    ->where('IsArchive',0)
    ->offset($start)
    ->limit($length)
    ->get();


    $data=[
      "draw"=>$draw,
      "recordsTotal" => $countplaces,
      "recordsFiltered" => $countplaces,
      "data" => $places
    ];


    return response()->json($data);
    // return response()->json($places);


    return response()->success(compact('places'));
  }

  public function getIndexWithActiveStatus()
  {
    $places = Place::whereNull('DeletedBy')
    ->where('IsArchive',0)
    ->select('Comments', 'Id')->get();



    return response()->success(compact('places'));
  }


// public function getplaceView($id){
//         $placeDetail = Place::find($id);
//         $place = array();
//         if(isset($placeDetail) && !empty($placeDetail)){
//               $place['Name'] = $placeDetail->Name;
//               $place['Comments'] = $placeDetail->Comments;
//               $place['Type'] = $placeDetail->Type;
//               $place['IsActive'] = $placeDetail->IsActive;

//               $place['created_at'] = $placeDetail->created_at;
//               $place['updated_at'] = $placeDetail->updated_at   ;
//               $DeletedBy = $placeDetail->DeletedBy;
//               $CreatedBy = $placeDetail->CreatedBy; 
//               $ModifiedBy = $placeDetail->ModifiedBy;

//               $Deleted = User::find($DeletedBy);
//               if(isset($Deleted) && !empty($Deleted)){
//                     $place['DeletedBy'] = $Deleted->name;
//                  }
//               $Created = User::find($CreatedBy);
//               if(isset($Created) && !empty($Created)){
//                     $place['CreatedBy'] = $Created->name;
//                  }
//               $Modified = User::find($ModifiedBy);
//               if(isset($Modified) && !empty($Modified)){
//                     $place['ModifiedBy'] = $Modified->name;
//                  }
//         }   
//         return response()->success($place);
// }

  public function getplace($id)
  {

   $place = DB::table('places')
   ->where('places.Id',$id)
   ->leftjoin('users as usercre', function($join){
                $join->orOn('usercre.id','=','places.createdby'); // i want to join the users table with either of these columns
              })
   ->leftjoin('users as usermod', function($join){
    $join->orOn('usermod.id','=','places.modifiedby');
  })
   ->leftjoin('users as userdel', function($join){
    $join->orOn('userdel.id','=','places.DeletedBy');
  })
   ->select('places.*','usercre.name as Created','usermod.name as Modified','userdel.name as Deleted')
   ->first();

   return response()->success($place);
 }

 public function put()
 {
  $blogeditForm = \Input::get('data');
  $id=$blogeditForm['Id'];
  $blog=Place::find($id);
       // $blogeditForm['slug'] = str_slug($blogeditForm['slug'], '.');
  $blogeditForm['updated_at'] =\Carbon\Carbon::now()->toDateTimeString();
  $blogeditForm['ModifiedBy'] = Auth::user()->id;

  $blog->update($blogeditForm);

  return response()->success($blogeditForm);
}

/*Place archive */
public function delete($Id)
{	
    // dd($Id);
  $useriddd=Auth::user()->id;        
  $place=Place::find($Id);
  $place->update(['IsArchive'=>1,'DeletedBy'=>$useriddd]);

  return response()->success('success');
}

/*Place archive multipal place */
public function deletes(Request $request)
{   
  $data = $request->input('data');  
  $useriddd=Auth::user()->id;        

  foreach ($data as $id) {

    $place=Place::find($id);
    $place->update(['IsArchive'=>1,'DeletedBy' => $useriddd]);
  }

    // Place::whereIn('Id', $data)->update(['DeletedBy' => $useriddd]);

  return response()->success('success');
}

public function getdeletedIndex()
{
  $deletedplace = place::whereNotNull('DeletedBy')->where('IsArchive',1)->get();

  return response()->success(compact('deletedplace'));
}

public function recover($Id)
{         
  $data['IsArchive']=intval(0);
  $data['updated_at'] =\Carbon\Carbon::now()->toDateTimeString();
  $data['DeletedBy'] =NULL;
  $data['ModifiedBy'] = Auth::user()->id;

  $place=place::find($Id);
  $place->update($data);

  return response()->success('success');
}

/*Place controller Hard delete*/

public function harddelete($Id){
 $userid =  Auth::user()->id;
 $userroledetail = \DB::table('role_user')
 ->join('roles', 'role_user.role_id', '=', 'roles.id')
 ->Where('role_user.user_id', '=',$userid)
 ->select('roles.slug')
 ->first();

 if(!empty($userroledetail) && $userroledetail->slug == 'Admin' ){
   $place = place::find($Id);
   try{
     $place->delete();
     return response()->success('success');
   }
   catch (\Exception $e){
    return response()->error($e->getMessage());
  }
}else{
  return response()->success('error');
}
}

}
