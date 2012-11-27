<?php

function cmd($cmd){
    ob_start();
    system($cmd, $ret);
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}
class Git
{
    protected $_results = array();
    protected $_changes = array(
        'add' => array(),
        'modified' => array(),
        'deleted' => array(),
        'new file' => array()
    );
    public function execute($cmd)
    {
        
        ob_start();
        system($cmd, $ret);
        $ret = ob_get_contents();
        ob_end_clean();
        $this->_results = explode("\n", $ret);
        return $this->_results;
    }
    public function status()
    {
        //Changes not staged for commit:
        $this->execute('git status');
        
        $signs = array(
            '# Untracked files:' => 'new',
            '# Changes not staged for commit:' => 'edit'
        );
        $current = '';
        for($i=0, $l=count($this->_results); $i<$l; $i++){
            $line = trim($this->_results[$i]);
            if(isset($signs[$line])){
                $current = $signs[$line];
            }else{
                if(preg_match('/^#([\t]+)([^\(]+)/', $line, $matches)){
                    if (preg_match('/(modified|deleted|new file):[\t\s]+([^\n]+)/', $matches[2], $matches2)){
                        array_push($this->_changes[$matches2[1]], $matches2[2]);
                    }else{
                        array_push($this->_changes['add'], $matches[2]);
                    }
                }
            }
        }
    }
    public function prepare()
    {
        $type2cmd = array(
            'add' => 'add',
            'modified' => 'add',
            'deleted' => 'rm'
        );
        $adds = array_merge($this->_changes['add'], $this->_changes['modified'], $this->_changes['new file']);
        $rms = $this->_changes['deleted'];
        
        $adds = array_unique($adds);
        $rms = array_unique($rms);
        $this->add($adds);
        $this->rm($rms);
    }
    public function add($files)
    {
        if ($files){
            echo $cmd = "git add '".implode("' '", $files)."'";
            $this->execute($cmd);
        }
    }
    public function rm($files)
    {
        if ($files){
            echo $cmd = "git rm -r '".implode("' '", $files)."'";
            //$this->execute($cmd);
        }
        
    }
    public function commit($files, $msg)
    {
        if (is_array($files)){
            $files = "'".implode("' '", $files)."'";
        }
        $cmd = "git commit -m'{$msg}' {$files}";
        $this->execute($cmd);
    }
}

$git = new Git();
$git->status();
$git->prepare();
//var_dump($git);
$git->commit('.', '...');

