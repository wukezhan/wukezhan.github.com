<?php
/**
 * @author wukezhan
 * 自动提交、发布文章或代码
 */

include 'git.php';

$git = new Git();
$git->status();
$git->prepare();
$git->commit('.', '...');
$git->push();

