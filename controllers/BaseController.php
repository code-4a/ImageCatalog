<?php

class BaseController {
    
    protected function allRecords($model, $viewPath)
    {
        $params = ['records' => $model::getAll()];
        View::currentView()->addFile($viewPath . '/all', $params);
        return $params;
    }
    
    protected function oneRecord($model, $viewPath, $urlParams)
    {
        $object = $model::getOne((int)$urlParams[1]);
        View::currentView()->addFile(
                (empty($object) ? '404' : $viewPath .'/one'), 
                ['record' => $object]);
        return $object;
    }

    protected function findRecords($model, $viewPath, $urlParams)
    {
        $modelObject = new $model();
        $input = (new HttpPostVars())->equalObjectFields($modelObject);
        $form = HttpForm::fromObjectFields($modelObject);
        $form->setActionAddress($urlParams[0]);
        View::currentView()->addHtml($form->getHtmlCode());
        if($input->isFillAny()) {
            $records = $model::find($input->getFillVars());
            View::currentView()->addFile($viewPath . '/find', 
                    ['records' => $records]);
            return $records;
        }
        return false;
    }
    
    protected function manageRecord($object, $urlParams, $location)
    {
        $input = (new HttpPostVars())->equalObjectFields($object);
        $keyName = $object->getKeyFieldName();
        if(!empty($object->$keyName)) $input->addKeyToRequired();
        if($input->isFillAllRequired()) {
            $input->fillObject($object);
            $object->save();
            header('Location: ' . $location);
        } else {
            $form = HttpForm::fromObjectFields($object);
            if(!empty($object->$keyName)) $form->addKeyToForm();
            View::currentView()->addHtml($form->getHtmlCode());
        }    
    }
    
    protected function deleteRecord($model, $urlParams, $location)
    {
        $object = new $model();
        $keyName = $object->getKeyFieldName();
        $object->$keyName = $urlParams[1];
        $object->delete();
        header('Location: ' . $location);
    }
}
