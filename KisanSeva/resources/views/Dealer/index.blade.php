<!--
* File    : index.blade.php
* Author  : Saurabh Mehta
* Date    : 24-Mar-2017
* Purpose : Admin home Screen  -->
<!DOCTYPE html>
@extends('layouts.master')
  @section('title')
    <title>Dealer | Home</title>
  @stop
  @section('sidebar')
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="active treeview">
        <a href="{{ URL::to('dealer') }}">
          <i class="fa fa-home"></i>
          <span>Home</span>
        </a>
      </li>
      <li class="treeview">
        <a href="{{ URL::to('viewads') }}">
          <i class="fa fa-files-o"></i>
          <span>View Crop Posts</span>
        </a>
      </li>
    </ul>
  @stop
  @section('content')
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          {{ Session::get('name') }}
          Dashboard
          <small>Dealer</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ URL::to('dealer') }}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>Rs {{ number_format($dashboardData['countPost'][3]) }}</h3>
                <p>Total Expenditure</p>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
              <a href="{{ URL::to('viewads') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $dashboardData['countPost'][1] }}</h3>

              <p>Crop Post Active</p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            <a href="{{ URL::to('viewads') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $dashboardData['countPost'][0] }}</h3>

              <p>Crop Post Purchased</p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            <a href="{{ URL::to('viewads') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $dashboardData['countPost'][2] }}</h3>

              <p>Crop Post Rejected</p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            <a href="{{ URL::to('viewads') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



      </div>
      <div class="row">
        <section class="col-lg-7 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>
              <h3 class="box-title">Quick Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="email" method="post">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject">
                </div>
                <div>
                  <textarea class="textarea" placeholder="Message" name="content" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
                            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-default" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
              </form>
            </div>
          </div>
        </section>

      </div>
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>
@stop