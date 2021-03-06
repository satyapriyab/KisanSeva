<?php
/**
* File: FarmerController.php
* Purpose: Calls the FarmerModal to fetch the data required for farmer pages.
* Date: 24/03/2017
* Author: SatyaPriya Baral
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\FarmerModel;
use App\Http\Requests;
use App\Classes;
use App\Services\Farmer\FarmerServices;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use App\Post;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Image;

/**
* Class containing all functions for the farmer services.
*/
class FarmerController extends Controller
{

    /**
    * Function to go to Farmer View.
    *
    * @param array $request - Contains all session data.
    * @return - Returns to the desired view of desired user.
    */
    public function farmer(Request $request)
    {
        //get all dashboard data of user
        $dashboardData = FarmerServices::findDashboardData($request->session()->get('user'));
        return view('farmer.index', compact('dashboardData'));
    }
    /**
    * Function to get All Farming Tips Data.
    *
    * @param array Reguest - Contains all session data.
    * @return - Filemaker results of all Farming Tips found.
    */
    public function findAllTips(Request $request)
    {
        //get all tips data.
        $records = FarmerServices::findAllTips('Tips');
        return view('farmer.farmingtips', compact('records'));
    }

    /**
    * Function to get Specific Farming Tips Data.
    *
    * @param int $id - contains record id of specific farming tip to be displayed.
    * @return - Filemaker results of Farming Tips found.
    */
    public function tipDetails($id)
    {
        //get details of a specific tip.
        $tips = FarmerServices::tipDetails($id);
        return view('farmer.tipsdetails', compact('tips'));
    }

    /**
    * Function to get all the Category.
    *
    * @return - Filemaker results of Category Found.
    */
    public function findAllCategory()
    {
        //find all category details.
        $records = FarmerServices::findAllCategory();
        return view('farmer.addpost', compact('records'));
    }

    /**
    * Function to Find all Crops Under Category.
    *
    * @param int $request - contains id of the Category and all session data.
    * @return - Filemaker results of Crops Found under Category.
    */
    public function findCrops(Request $request)
    {
         //find all crops under category
        $records = FarmerServices::findCrops($request->id);
        return response()->json($records);
    }

    /**
    * Function to Find all Crops Under Category.
    *
    * @param int $request - contains id of the Category and all session data.
    * @return - Filemaker results of Crops Found under Category.
    */
    public function postDetails(Request $request)
    {
        //find details of all crops.
        $postDetails = FarmerServices::findCropDetails($request->id);
        return view('farmer.postdetails', compact('postDetails'));
    }

    /**
    * Function to Create a Post of the crop.
    *
    * @param array $request - contains all data of the post to be created and all session data.
    * @return - Returns to the Crop post page.
    */
    public function createPost(Request $request)
    {
        //validation of crop data to be posted
        $validator = Validator::make($request->all(), [
            'Category' => 'required',
            'Crop' => 'required',
            'Quantity' => 'required',
            'Weight' => 'required',
            'BasePrice' => 'required',
            'ExpiryTime' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('addpost')->withErrors($validator);
        }
        //creating the post if validatinn is succesful);
        if ($request->hasfile('imageData')) {
            $image = $request->file('imageData');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->resize(150, 150)->save($location);
            $addPost = FarmerServices::createPost($request->all(), $request->session()->get('user'), $filename);
        } else {
            $addPost = FarmerServices::createPost($request->all(), $request->session()->get('user'), 0);
        }
        if ($addPost) {
            return redirect('viewpost');
        }

        return back();
    }
    /**
    * Function to get all posts.
    *
    * @param array Reguest - Contains all session data.
    * @return - Array of all post data.
    */
    public function findAllPosts(Request $request)
    {
        $sessionArray = $request->session()->all();
        $records = FarmerServices::findAllPosts($request->all(), $sessionArray['user']);

        if ($records !== false) {
            return view('farmer.ViewPost', $records);
        }

        return view('farmer.ViewPost')->withErrors(['message' => 'No Post Found']);
    }

    /**
    * Function to get all profile data of farmer.
    *
    * @param array $request - contains all session data.
    * @return - Returns to the Crop post page.
    */
    public function profile(Request $request)
    {
        $sessionArray = $request->session()->all();
        $profileData = FarmerServices::profile($sessionArray['user']);
        $post = FarmerServices::postCount($sessionArray['user']);

        if ($profileData != false) {
            return view('farmer.profile', compact('profileData', 'post'));
        }

        return false;
    }

    /**
    * Function to sign in to the required user home page.
    *
    * @param array Reguest - Contains all data of user for login.
    * @return - Returns to the route of desired user.
    */
    public function editProfile(Request $request)
    {
        //validation of field for edit.
        $validator = Validator::make($request->all(), [
            'Name' => 'required|min:5',
            'Contact' => 'required|min:10|max:10'
        ]);

        if ($validator->fails()) {
            return redirect('profile')->withErrors($validator);
        }

        $sessionArray = $request->session()->all();
        if ($request->hasfile('imageData')) {
            $image = $request->file('imageData');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->resize(200, 200)->save($location);
            $request->session()->put('userImage', $filename);
            FarmerServices::editProfile($request->all(), $sessionArray['recordId'], $filename);
        } else {
            FarmerServices::editProfile($request->all(), $sessionArray['recordId'], 0);
        }
        //if validation succesful edit the profile
        $request->session()->put('name', $request->Name);
        return redirect('profile');
    }

    /**
    * Function to accept the bid of a farmer.
    *
    * @param array $request - contains id of the bid.
    * @return - Filemaker results of result.
    */
    public function acceptBid(Request $request)
    {
        $acceptBid = FarmerServices::acceptBid($request->id);
        return back();
    }

    /**
    * Function to Create Comments.
    *
    * @param array $request - contains all data of comment to be created and all session data.
    * @return - Returns to the postDetails page.
    */
    public function comment(Request $request)
    {
        //validation of comment data
        $validator = Validator::make($request->all(), [
            'commentData' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('postDetails')->withErrors($validator);
        }
        //create a comment if validation succesful.
        $sessionArray = $request->session()->all();
        $addComment = FarmerServices::createComment($request->all(), $sessionArray['user'], $request->id);
        if ($addComment) {
            return back();
        }
        return back();
    }

    /**
    * Function to Delete Post.
    *
    * @param  array $request - contains all data of post to be deleted.
    * @return - Return bollian value for true or false.
    */
    public function delete(Request $request)
    {
        $deletePost = FarmerServices::delete($request->id);
        return back();
    }
}
