<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 3/17/2018
 * Time: 2:36 PM
 *
 * This file creates the profile variables needed
 * when viewing a profile page
 */

$member = retrieveUser($params['username']);


//Sets other fat free variables for displaying in profile
$f3->set('profileScore', $member->getScore());
$f3->set('profileUsername', $member->getUsername());
$f3->set('profileTotalPlayed', $member->getTotalPlayed());


//Creates array of categoryu counts for displaying
$categoryCounts = [];
$memberCounts = $member->getCategoryCounts();
$categories = array(
    'Science', 'Code', 'Sports', 'Art', 'Random', 'History',
    'Geography', 'General Culture', 'Celebrties'
);
for ($cat = 0 ; $cat < 9 ; $cat++) {
    $categoryCounts[$categories[$cat]] = $memberCounts[$cat];
}


//Sets the fat free variable for displaying on the profile page
$f3->set('categoryCounts', $categoryCounts);