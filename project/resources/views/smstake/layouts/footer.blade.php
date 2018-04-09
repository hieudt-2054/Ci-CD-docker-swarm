@section('footer')
@show

<script src="{{ asset('smstake/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('smstake/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('smstake/js/modernizr.min.js') }}"></script>
<script src="{{ asset('smstake/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('smstake/js/toggles.min.js') }}"></script>
<script src="{{ asset('smstake/js/retina.min.js') }}"></script>
<script src="{{ asset('smstake/js/jquery.cookies.js') }}"></script>


<script src="{{ asset('smstake/js/custom.js') }}"></script>

<script src="{{ asset('smstake/js/jquery.datatables.min.js') }}"></script>
<script src="{{ asset('smstake/js/select2.min.js') }}"></script>
<script>
    jQuery(document).ready(function () {

        "use strict";

        jQuery('#table1').dataTable();


        // Select2
        jQuery(".select2").select2({
            width: '100%'
        });

        jQuery('select').removeClass('form-control');

        // Delete row in a table
        jQuery('.delete-row').click(function () {
            var c = confirm("Continue delete?");
            if (c)
                jQuery(this).closest('tr').fadeOut(function () {
                    jQuery(this).remove();
                });

            return false;
        });

        // Show aciton upon row hover
        jQuery('.table-hidaction tbody tr').hover(function () {
            jQuery(this).find('.table-action-hide a').animate({opacity: 1});
        }, function () {
            jQuery(this).find('.table-action-hide a').animate({opacity: 0});
        });


    });


</script>


