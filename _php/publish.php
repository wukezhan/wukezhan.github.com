<?php
/**
 * 发布
 */
include 'git.php';

$git = new Git();
$git->status();
$git->prepare();
$git->commit('.', '...');
$git->push();

