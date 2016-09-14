<?php

class TagController extends BaseController{
    
    public function all($urlParams)
    {
        $this->allRecords('Tag', 'tag');
    }
    
    public function one($urlParams)
    {   
        $this->oneRecord('Tag', 'tag', $urlParams);
    }
    
    public function find($urlParams)
    {
        $this->findRecords('Tag', 'tag', $urlParams);
    }
    
    public function add($urlParams)
    {
        $this->manageRecord(new Tag(), $urlParams, '/tags');
    }
    
    public function edit($urlParams)
    {
        $tag = Tag::getOne((int)$urlParams[1]);
        if(empty($tag)) {
            View::currentView()->addFile('404', []);
            return;
        }
        $this->manageRecord($tag, $urlParams, '/tags');
    }

    public function delete($urlParams)
    {
        $this->deleteRecord('Tag', $urlParams, '/tags');
    }
    
    public function def1($urlParams)
    {
        echo 'TagController::def'  . "\n"
                . var_dump($urlParams);
    }
}
