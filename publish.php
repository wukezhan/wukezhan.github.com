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
        'deleted' => array()
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
                    if (preg_match('/(modified|deleted):[\t\s]+([^\n]+)/', $matches[2], $matches2)){
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
        $adds = array_merge($this->_changes['add'], $this->_changes['modified']);
        $rms = $this->_changes['deleted'];
        
        $this->add($adds);
        $this->rm($rms);
    }
    public function add($files)
    {
        $cmd = "git add '".implode("' '", $files)."'";
        $this->execute($cmd);
    }
    public function rm($files)
    {
        $cmd = "git rm '".implode("' '", $files)."'";
        $this->execute($cmd);
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
$git->commit('.', '...');

