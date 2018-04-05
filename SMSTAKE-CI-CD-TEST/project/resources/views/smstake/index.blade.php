@extends('smstake.layouts.main')

@section('pageTitle','Home')

@section('breadcrumb')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> Home <span>Overview and Status</span></h2>
        <div class="breadcrumb-wrapper">
            {!! $breadcrumbs !!}
        </div>
    </div>
@endsection

@section('MainContent')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-success panel-stat">
                <div class="panel-heading">
                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="fa fa-comments fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Sent Messages</small>
                                <h1>900k+</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <a href="">
                                <div class="col-xs-10">
                                    <span>View Details</span>
                                </div>

                                <div class="col-xs-2">
                                    <span class="fa fa-arrow-circle-right"></span>
                                </div>
                            </a>
                        </div><!-- row -->
                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-3">
            <div class="panel panel-danger panel-stat">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="fa fa-th-list fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Balance Massege</small>
                                <h1>54.40%</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <a href="">
                                <div class="col-xs-10">
                                    <span>View Details</span>
                                </div>

                                <div class="col-xs-2">
                                    <span class="fa fa-arrow-circle-right"></span>
                                </div>
                            </a>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-3">
            <div class="panel panel-primary panel-stat">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="fa fa-shopping-cart fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Buy Credits</small>
                                <h1>300k+</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <a href="">
                                <div class="col-xs-10">
                                    <span>View Details</span>
                                </div>

                                <div class="col-xs-2">
                                    <span class="fa fa-arrow-circle-right"></span>
                                </div>
                            </a>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-3">
            <div class="panel panel-dark panel-stat">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="fa fa-send fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Sender IDs</small>
                                <h1>$655</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <a href="">
                                <div class="col-xs-10">
                                    <span>View Details</span>
                                </div>

                                <div class="col-xs-2">
                                    <span class="fa fa-arrow-circle-right"></span>
                                </div>
                            </a>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div><!-- row -->
@endsection
