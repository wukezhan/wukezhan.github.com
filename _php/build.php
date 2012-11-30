<?php
include 'git.php';
function simple_array_parse($str){
    $str = trim($str);
    $arr = array();
    if (preg_match("/\[([^[]+)\]/", $str, $matches)){
        $arr = explode(',', $matches[1]);
    }else{
        $arr = explode(' ', $str);
    }
    return $arr;
}
$git = new Git();
$git->status();

$changes = $git->getChanges();

$posts = array();
foreach ($changes as $files){
    foreach ($files as $file){
        if (preg_match('/^_posts\//', $file)){
            $posts[] = $file;
        }
    }
}

$cates = array();
$tags = array();
foreach ($posts as $post){
    $contents = file_get_contents($post);
    if (preg_match('/\-\-\-([\s\S]{0,})\-\-\-/', $contents, $matches)){
        $metas = explode("\n", $matches[1]);
        foreach ($metas as $meta){
            if (preg_match("/^(category|categories):(.*?)$/", $meta, $matches)){
                $cates = array_merge($cates, simple_array_parse($matches[2]));
            }else if (preg_match("/^tags:(.*?)$/", $meta, $matches)){
                $tags = array_merge($tags, simple_array_parse($matches[1]));
            }
        }
    }
}

$catetpl = '---
layout: category
title: __CATE__
---';


foreach ($cates as $cate){
    $cate = trim($cate);
    $cateFileName = "category/{$cate}";
    if (!file_exists($cateFileName)){
        mkdir($cateFileName);
        file_put_contents($cateFileName.'/index.html', str_replace('__CATE__', $cate, $catetpl));
        echo "{$cateFileName} built.\n";
    }
}


$tagtpl = '---
layout: tag
title: __TAG__
---';
foreach ($tags as $tag){
    $tag = trim($tag);
    $tagFileName = "tag/{$tag}";
    if (!file_exists($tagFileName)){
        mkdir($tagFileName);
        file_put_contents($tagFileName.'/index.html', str_replace('__TAG__', $tag, $tagtpl));
        echo "{$tagFileName} built.\n";
    }
}

