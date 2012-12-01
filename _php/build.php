<?php
/**
 * @author wukezhan
 * 尝试为有改动的文章生成分类和标签
 */

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
        $meta = mb_convert_encoding($matches[1], 'utf8', 'iso-8859-1');
        $metas = explode("\n", $meta);echo $meta,"\n";
        foreach ($metas as $meta){
            if (preg_match("/^(category|categories):(.*?)$/", $meta, $matches)){
                $cates = array_merge($cates, simple_array_parse($matches[2]));
            }else if (preg_match("/^tags:(.*?)$/", $meta, $matches)){
                $tags = array_merge($tags, simple_array_parse($matches[1]));
            }
        }
    }
}
var_dump($tags);
$catetpl = '---
layout: category
title: __CATE__
---';


foreach ($cates as $cate){
    $cate = trim($cate);
    //$cateFileName = mb_convert_encoding("category/{$cate}", 'utf8', 'ascii');
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
    //$tagFileName = mb_convert_encoding("tag/{$tag}", 'utf8', 'ascii');
    $tagFileName = "tag/{$tag}";
    if (!file_exists($tagFileName)){
        mkdir($tagFileName);
        file_put_contents($tagFileName.'/index.html', str_replace('__TAG__', $tag, $tagtpl));
        echo "{$tagFileName} built.\n";
    }
}

