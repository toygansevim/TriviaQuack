<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 3/17/2018
 * Time: 2:36 PM
 */

$member = retrieveUser($params['username']);

$f3->set('score', $member->getScore());
//$f3->set('totalPlayed', $member->getTotalPlayed());

$categoryCounts = [];

$memberCounts = $member->getCategoryCounts();

$categories = array(
    'Science', 'Code', 'Sports', 'Art', 'History',
    'Geography', 'General Culture', 'Celebrties'
);

for ($cat = 0 ; $cat < 8 ; $cat++) {
    $categoryCounts[$categories[$cat]] = $memberCounts[$cat];
}

$f3->set('categoryCoutns', $categoryCounts);