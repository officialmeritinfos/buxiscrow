<?php
namespace App\Custom;
use App\Models\BusinessCategory;
use App\Models\BusinessSubcategory;

/**
 *  custom checks for data in the database which will
 *  be globally used instead of using yhem in the controller
 */
class CustomChecks{

    public static function CategoryExists($id){
        $category = BusinessCategory::where('id',$id)->where('status',1)->first();
        $dataCate = (!empty($category)) ? ['found'=>true,'data'=>$category] : $dataCate = ['found'=>false];
        return $dataCate;
    }
    public static function SubCategoryExists($id){
        $category = BusinessSubcategory::where('id',$id)->where('status',1)->first();
        $dataCate = (!empty($category)) ? ['found'=>true,'data'=>$category] : $dataCate = ['found'=>false];
        return $dataCate;
    }
    public static function SubcategoryHasCategory($subid,$catid){
        $category = BusinessSubcategory::where('id',$subid)->where('category_id',$catid) ->where('status',1)->first();
        $dataCate = (!empty($category)) ? ['found'=>true,'data'=>$category] : $dataCate = ['found'=>false];
        return $dataCate;
    }
    public static function statusvar($st){
        switch ($st){
            case 1:
                $status = 'Active';
                break;
            default:
                $status = 'inactive';
                break;
        }
        return $status;
    }
    public static function verificationVar($vt){
        switch ($vt){
            case 1:
                $ver = 'Verified';
                break;
            default:
                $ver = 'Not Verified';
                break;
        }
        return $ver;
    }
    public static function chargeVar($ct){
        switch ($ct){
            case 1:
                $charge = 'Clients Pay';
                break;
            default :
                $charge = 'Business pay';
                break;
        }
        return $charge;
    }
    public static function categoryVar($ct){
        $category = BusinessCategory::where('id',$ct)->where('status',1)->first();
        return $category->category_name;
    }
    public static function subcategoryVar($ct){
        $category = BusinessSubcategory::where('id',$ct)->where('status',1)->first();
        return $category->subcategory_name;
    }
    public static function transactionTypeVar($tT){
        switch ($tT){
            case 2:
                $type = 'Payout';
                break;
            case 3:
                $type = 'Escrow';
                break;
            case 4:
                $type = 'Airtime';
                break;
            case 5:
                $type = 'Bill';
                break;
            case 6:
                $type = 'Remita';
                break;
            case 7:
                $type = 'Payment Link';
                break;
            default :
                $type = 'Funding';
                break;
        }
        return $type;
    }
}
