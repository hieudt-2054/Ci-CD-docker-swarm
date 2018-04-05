<div class="leftpanel">

                <div class="logopanel">
                    <h1><span>[</span> SMSPANEL <span>]</span></h1>
                </div><!-- logopanel -->

                <div class="leftpanelinner">

                    <!-- This is only visible to small devices -->
                    {{-- <div class="visible-xs hidden-sm hidden-md hidden-lg">   
                        <div class="media userlogged">
                            <img alt="" src="{{ asset('smstske/images/photos/loggeduser.png') }}" class="media-object">
                            <div class="media-body">
                                <h4>John Doe</h4>
                                <span>"Life is so..."</span>
                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">Account</h5>
                        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                            <li><a href="profile.html"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                            <li><a href=""><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
                            <li><a href=""><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
                            <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                        </ul>
                    </div> --}}

                    <h5 class="sidebartitle">Navigation</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li class="nav-parent"><a href=""><i class="fa fa-envelope-o"></i> <span>TEXT</span></a>
                            <ul class="children">
                                <li><a href="{{ route('quick-sms.index') }}"><i class="fa fa-caret-right"></i> Quick SMS</a></li>
                                <li><a href="#"><i class="fa fa-caret-right"></i> SEND SMS</a></li>
                                <li><a href="#"><i class="fa fa-caret-right"></i> SEND CUSTOM SMS</a></li>
                                <li><a href="#"><i class="fa fa-caret-right"></i> MANAGE SCHEDULE SMS </a></li>
                                <li><a href="#"><i class="fa fa-caret-right"></i> MANAGE DRAFTS </a></li>
                            </ul>
                        </li>
                         <li class="nav-parent"><a href=""><i class="fa fa-pie-chart"></i> <span>REPORTS</span></a>
                            <ul class="children">
                                <li><a href="#"><i class="fa fa-caret-right"></i> DELIVERY REPORTS</a></li>
                                <li><a href="#"><i class="fa fa-caret-right"></i> REPORTS SUMMARY</a></li>
                            </ul>
                        </li>
                        <li class="nav-parent"><a href=""><i class="fa fa-user-o"></i> <span>SENDER ID</span></a>
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

                    

                </div><!-- leftpanelinner -->
            </div>