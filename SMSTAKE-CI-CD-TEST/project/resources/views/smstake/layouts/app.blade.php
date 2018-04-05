<!DOCTYPE html>
<html lang="en">
<head>
    @include('smstake/layouts/head')
</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>


<section>
@include('smstake/layouts/sidebar')
<!-- leftpanel -->

    <div class="mainpanel">

    @include('smstake/layouts/navbar')
    <!-- headerbar -->
        @include('smstake/layouts/breadcrumb')


        <div class="contentpanel">
            <!-- content goes here... -->
            @section('MainContent')

            @show
        </div>

    </div><!-- mainpanel -->


</section>

@include('smstake/layouts/footer')


</body>
</html>
