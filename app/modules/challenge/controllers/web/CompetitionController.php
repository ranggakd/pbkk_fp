<?php

namespace Dengarin\Challenge\Controllers\Web;

use Dengarin\Challenge\Controllers\ModuleController;
use Dengarin\Challenge\Models\Competition;
use Dengarin\Challenge\Models\Submission;

class CompetitionController extends ModuleController
{
    public function indexAction()
    {
        $this->view->title = "Competition";
        /*
        * Read all competition
        */
        $this->view->competition = Competition::find();
        $dates = $this->view->competition;
        $sign = [];
        $readable_date = [];
        foreach ($dates as $date) {
            $now = time();
            $duedate = strtotime($date->duedate);
            $diff = $now - $duedate;
            $sign[] = $diff <= 0 ? false : true;
            $dues = getdate($duedate);
            $d = "$dues[weekday], $dues[month] $dues[mday] $dues[year]";
            $readable_date[] = $d;
        }
        // change the button if the challenge past due
        $this->view->setVars([
            'expired' => $sign,
            'readable_date' => $readable_date
        ]);
    }
    
    public function showAction()
    {
        /*
        * Read particular competition
        */
        $id = $this->dispatcher->getParam('id');
        $competition = Competition::findFirst($id);
        $this->view->competition = $competition;
        // unlocked submission if the challenge past due
        $dates = $competition->duedate;
        $now = time();
        $duedate = strtotime($dates);
        $diff = $now - $duedate;
        $sign = $diff <= 0 ? false : true;
        
        // get readable date
        $dues = getdate($duedate);
        $d = "$dues[weekday], $dues[month] $dues[mday] $dues[year]";
        $title = $competition->title . ' - Competition Management';

        // get id user from auth session
        $userid = $this->auth()->id;

        $this->view->setVars([
            'title' => $title,
            'expired' => $sign,
            'readable_date' => $d,
            'iduser' => $userid
        ]);
        /*
        * Read any submission from user
        */
        if ($this->request->isPost())
        {
            if ($this->request->getPost("create"))
            {
                /*
                * Creating new submission
                */                
                if ($this->request->hasFiles())
                {

                }else{
                    $this->flashSession->error('Failed to upload your submission');
                    $this->response->redirect(['for' => 'per_competition']);
                }
            }elseif ($this->request->getPost("edit")) {
                
            }elseif ($this->request->getPost("delete")) {

            }
        }
    }
}