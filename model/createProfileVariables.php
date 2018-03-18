<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 3/17/2018
 * Time: 2:36 PM
 */

$member = retrieveUser($params['username']);

$f3->set('profileScore', $member->getScore());
$f3->set('profileUsername', $member->getUsername());
$f3->set('profileTotalPlayed', $member->getTotalPlayed());

$categoryCounts = [];

$memberCounts = $member->getCategoryCounts();

$categories = array(
    'Science', 'Code', 'Sports', 'Art', 'Random', 'History',
    'Geography', 'General Culture', 'Celebrties'
);

for ($cat = 0 ; $cat < 9 ; $cat++) {
    $categoryCounts[$categories[$cat]] = $memberCounts[$cat];
}

$f3->set('categoryCounts', $categoryCounts);

//$f3->set('categoryCounts', $member->getCategoryCounts());

print_r($categoryCounts);
print_r($memberCounts);