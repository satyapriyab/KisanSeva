<?php
/**
* File: UsersController.php
* Purpose: Calls the FMUser class to fetch the data from filemaker database
* Date: 17/03/2017
* Author: SatyaPriya Baral
*/
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;
use App\FMUser;
use App\Http\Requests;
use App\Classes;
class UsersController extends Controller
{
    /*
     * Show all the list of users in the database
     * @param void
     * @return list of users
     */
    public function index()
    {
      //  $records = new FMUser();
       // $records->showall();
       //$records = Task::all();
      //  return view('test', c
        $records1 = FMUser::showAll('User');
        $records2 = FMUser::showAll('Tips');
        return view('test', compact('records1', 'records2'));
        /*$datas = FMUser::showAll();
        return view('test', compact('datas'));*/
        $records = FMUser::showAll();
        return view('test', compact('records'));

    }
    
    public function index1()
    {
      //  $records = new FMUser();
       // $records->showall();
       //$records = Task::all();
      //  return view('test', compact('records'));

        $datas = FMUser::showAll();
        return view('test', compact('datas'));
    }
    
    /*public function ViewTips() {
      $records2 = FMUser::showAll('Tips');
      return view('test2',compact('records'));

    }*/

    public function create() {
      $records = FMUser::create('User');
      return view('',compact('records'));
    }
}