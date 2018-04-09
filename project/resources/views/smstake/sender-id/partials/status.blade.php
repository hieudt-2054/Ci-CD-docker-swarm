@php
switch ($status){
    case 1:
        $labelClass = 'label-warning';
        $spanValue = 'Waiting for Approval';
    break;
    case 2:
        $labelClass = 'label-info';
        $spanValue = 'Assigned';
    break;
    case 3:
        $labelClass = 'label-success';
        $spanValue = 'Approved';
    break;
    case 4:
        $labelClass = 'label-danger';
        $spanValue = 'Rejected';
    break;
    default:
    break;
}
@endphp

<span class="customLabel label {{ $labelClass }}"> {{ $spanValue }}</span>
