<?php
/**
 * @author wukezhan
 * 简单的git类
 */

mb_internal_encoding("UTF-8");

class Git
{
    protected $_results = array();
    protected $_changes = array(
        'add' => array(),
        'modified' => array(),
        'deleted' => array(),
        'new file' => array()
    );
    public function cd($dir)
    {
        echo " > cd ",$dir,"\n";
        chdir($dir);
        return $this;
    }
    public function execute($cmd)
    {
        echo " > ",$cmd,"\n";
        ob_start();
        system($cmd, $ret);
        $ret = ob_get_contents();
        ob_end_clean();
        echo $ret;
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
        return $this;
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
        return $this;
    }
    public function add($files)
    {
        if ($files){
            $cmd = 'git add '.implode(' ', $files);
            $this->execute($cmd);
        }
        return $this;
    }
    public function rm($files)
    {
        if ($files){
            $cmd = 'git rm -r '.implode(' ', $files);
            $this->execute($cmd);
        }
        return $this;
    }
    public function commit($files, $msg)
    {
        if (is_array($files)){
            $files = implode(' ', $files);
        }
        $cmd = "git commit -m'{$msg}' {$files}";
        $this->execute($cmd);
        return $this;
    }
    public function push($to='origin', $from='master')
    {
        $cmd = "git push {$to} {$from}";
        $this->execute($cmd);
        return $this;
    }
    public function getChanges()
    {
        return $this->_changes;
    }
}
