<?php

class ImageController extends BaseController{
    
    public function all($urlParams)
    {
        $this->allRecords('Image', 'image');
    }
    
    public function one($urlParams)
    {   
        $this->oneRecord('Image', 'image', $urlParams);
    }
    
    public function find($urlParams)
    {
        $this->findRecords('Image', 'image', $urlParams);
    }
    
    public function add($urlParams)
    {
        $this->manageRecord(new Image(), $urlParams, '/images');
    }
    
    public function edit($urlParams)
    {
        $image = Image::getOne((int)$urlParams[1]);
        if(empty($image)) {
            View::currentView()->addFile('404', []);
            return;
        }
        $this->manageRecord($image, $urlParams, '/images');
    }

    public function delete($urlParams)
    {
        $this->deleteRecord('Image', $urlParams, '/images');
    }
}
