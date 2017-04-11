<!--
* File    : viewads.blade.php
* Author  : Saurabh Mehta
* Date    : 24-Mar-2017
* Purpose : View Advertisements for Dealers  -->
<!DOCTYPE html>
@extends('layouts.master')
  @section('title')
    <title>Dealer | View Adds</title>
  @stop
  @section('header')
    <link rel="stylesheet" href="{{ asset('template/dist/css/fresh-bootstrap-table.css') }}">
  @stop
  @section('sidebar')
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview">
        <a href="{{ URL::to('dealer') }}">
          <i class="fa fa-home"></i>
          <span>Home</span>
        </a>
      </li>
      <li class="active treeview">
        <a href="{{ URL::to('viewads') }}">
          <i class="fa fa-files-o"></i>
          <span>View Ads</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">4</span>
          </span>
        </a>
      </li>
      <li class="treeview">
        <a href="{{ URL::to('viewprevious') }}">
          <i class="fa fa-files-o"></i>
          <span>Purchasing History</span>
        </a>
      </li>
    </ul>
  @stop
  @section('content')
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="col-md-12">
              <div class="fresh-table">
                <table id="fresh-table" class="table">
                  <thead>
                    <th data-field="Category" data-sortable="true"><strong>Category</strong></th>
                    <th data-field="Crop" data-sortable="true"><strong>Crop</strong></th>
                    <th data-field="Time" data-sortable="true"><strong>Time Posted</strong></th>
                    <th data-field="quantity" data-sortable="true"><strong>Quantity</strong></th>
                    <th data-field="basePrice" data-sortable="true"><strong>Base Price</strong></th>
                    <th data-field="status"><strong>Status</strong></th>
                    <th data-field="action"><strong>Action</strong></th>
                  </thead>
                  <tbody>
                    @php
                      date_default_timezone_set('Asia/Kolkata');
                      $date = date("m/d/Y");
                      $time = date("h:i:sa");
                      $i = 0 ;
                    @endphp                <!-- /.box-header -->
                    @if(empty($PostRecords[0]))
                      {{ "No post present." }}
                    @else
                      @foreach($PostRecords[0] as $PostRecord[0])
                        <tr>
                          <td>{{ $PostRecords[1][$i][0] }}</td>
                          <td>{{ $PostRecord[0]->getField('CropName_t') }}</td>
                          <td>{{ $PostRecord[0]->getField('PublishedTime_t') }}</td>
                          <td>{{ $PostRecord[0]->getField('Quantity_xn') }}</td>
                          <td>Rs {{ $PostRecord[0]->getField('CropPrice_xn') }}</td>
                          @php
                            $today_time = strtotime($date);
                            $expire_time = strtotime($PostRecord[0]->getField('CropExpiryTime_xi'));
                            if($PostRecord[0]->getField('Sold_n') == 1) { 
                          @endphp
                          <td><span class="label label-success">Sold</span></td>
                          @php } elseif ($expire_time < $today_time) { @endphp
                          <td><span class="label label-danger">Expired</span></td>
                          @php } else { @endphp
                          <td><span class="label label-primary">Active</span></td>
                          @php } @endphp
                          <?php
                            $id = $PostRecord[0]->getrecordid() ?>
                            <td><Button class="label label-info" onclick="window.location='{{ url("postDetails",[$id]) }}'">View</Button></td>
                        </tr>
                        @php $i = $i+1; @endphp
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script src="{{ asset('template/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/dist/js/script.js?ver=1.4.11') }}"></script>
    <script type="text/javascript" src="{{ asset('template/dist/js/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/dist/js/bootstrap-table.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/dist/js/tableScript.js') }}">
    </script>
  @stop

