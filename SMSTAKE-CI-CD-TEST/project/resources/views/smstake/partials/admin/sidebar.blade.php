<div class="leftpanel">
    <div class="logopanel">
        <h1><span>[</span> SMSPANEL <span>]</span></h1>
    </div>
    <div class="leftpanelinner">
        <h5 class="sidebartitle">Navigation</h5>
        <ul class="nav nav-pills nav-stacked nav-bracket">
            <li class="nav-parent"><a href=""><i class="fa fa-envelope-o"></i> <span>TEXT</span></a>
                <ul class="children">
                    <li><a href="{{ route('quickSms.index') }}"><i class="fa fa-caret-right"></i> Quick SMS</a></li>
                    <li><a href="#"><i class="fa fa-caret-right"></i> SEND CUSTOM SMS</a></li>
                    <li><a href="{{ route('quickSms.list') }}"><i class="fa fa-caret-right"></i> MANAGE SCHEDULE SMS </a></li>
                    <li><a href="{{ route('draft.index') }}"><i class="fa fa-caret-right"></i> MANAGE DRAFTS </a></li>
                </ul>
            </li>
            <li class="nav-parent"><a href=""><i class="fa fa-pie-chart"></i> <span>REPORTS</span></a>
                <ul class="children">
                    <li><a href="#"><i class="fa fa-caret-right"></i> DELIVERY REPORTS</a></li>
                    <li><a href="#"><i class="fa fa-caret-right"></i> REPORTS SUMMARY</a></li>
                </ul>
            </li>
            <li class="nav-parent {{ isSideBarActive('senderID') }}"><a href=""><i class="fa fa-user-o"></i> <span>SENDER ID</span></a>
                <ul class="children">
                    <li><a href="{{ route('senderID.index') }}"><i class="fa fa-caret-right"></i> MANAGE SENDER ID</a></li>
                </ul>
            </li>
            <li class="nav-parent"><a href=""><i class="fa fa-user"></i> <span>CONTACTS</span></a>
                <ul class="children">
                    <li><a href="{{ route('group.index') }}"><i class="fa fa-caret-right"></i> MANAGE GROUP</a></li>
                    <li><a href="{{ route('contact.index') }}"><i class="fa fa-caret-right"></i> MANAGE CONTACT</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>