<?php

namespace App\Http\Controllers;

use App\Contracts\ReportServiceInterface;
use App\Models\User;

class HomeController extends Controller
{

    public function __construct(private ReportServiceInterface $reportService) {}

    public function index(){

//        $getUser=User::with('profile')->get()->map(function($user){
//            return [
//                'id'=>$user->id,
//                'name'=>$user->name,
//                'email'=>$user->email,
//                'profile'=>$user->profile ? [
//                    'id'=>$user->profile->id,
//                    'name'=>$user->profile->name,
//                    'email'=>$user->profile->email,
//                ]:null
//            ];
//        });
//        return $getUser;

//        $userInfo=User::with('comments')->get();
//        return $userInfo;

        dd("CSD");

        $posts = User::with([
            'comments' => fn ($comments) => $comments->chaperone(),
        ])->get();


        return $posts;
    }
}
