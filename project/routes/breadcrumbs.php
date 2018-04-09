<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

/****************************************************
 ******************Dashboard*************************
 ****************************************************/
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});
/**************End of Dashboard**************/



/******************************************************
 **********************Contact*************************
 *******************************************************/
Breadcrumbs::register('contact.index',function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Contact', route('contact.index'));
});
/************************End of Contact***********************/



/******************************************************
 **********************Group*************************
 *******************************************************/
Breadcrumbs::register('group.index',function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Group', route('group.index'));
});
/************************End of Group***********************/



/******************************************************
 **********************SenderID*************************
 *******************************************************/
Breadcrumbs::register('senderID.index',function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Sender-Id', route('senderID.index'));
});
/************************End of SenderID***********************/


/******************************************************
 **********************Draft*************************
 *******************************************************/
Breadcrumbs::register('draft.index',function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Draft', route('draft.index'));
});
/************************End of Draft***********************/


/******************************************************
 **********************QUICK SMS*************************
 *******************************************************/
Breadcrumbs::register('quickSms.index',function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Quick SMS', route('quickSms.index'));
});

Breadcrumbs::register('quickSms.list',function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Manage Scheduled SMS', route('quickSms.list'));
});
/************************End of QUICK SMS***********************/

