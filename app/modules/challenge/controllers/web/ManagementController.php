<?php

namespace Dengarin\Challenge\Controllers\Web;

use Dengarin\Challenge\Controllers\ModuleController;
use Dengarin\Challenge\Models\Competition;
use Dengarin\Challenge\Models\Submission;
use Phalcon\Dispatcher;

class ManagementController extends ModuleController
{
    const MARK = "_DENGAR-IN_";
    const COMPETITION_PATH = "/public/challenge_competition/";
    const SUBMISSION_PATH = "/public/challenge_submission/";

    public function rrmdir($dir): bool
    { 
        if (is_dir($dir)) { 
            $objects = scandir($dir); 
            foreach ($objects as $object) { 
                if ($object != "." && $object != "..") { 
                if (is_dir($dir."/".$object))
                    rrmdir($dir."/".$object);
                else
                    unlink($dir."/".$object); 
                } 
            }
            rmdir($dir);
            return true; 
        }else {
            return false;
        }
    }
    
    public function indexAction()
    {
        $this->view->title = 'Competition Management';
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
        $this->view->setVars([
            'expired' => $sign,
            'readable_date' => $readable_date
        ]);

        if ($this->request->isPost())
        {
            if ($this->request->getPost("create"))
            {
                /*
                * Creating new competition
                */
                if ($this->request->hasFiles())
                {
                    $filepath = '';
                    $files = $this->request->getUploadedFiles();
                    foreach ($files as $file) {
                        // regex of this title need to be verified for pathfile later
                        $image = $this->request->getPost("title") . self::MARK . $file->getName();
                        $file->moveTo(
                            BASE_PATH . self::COMPETITION_PATH . $image
                        );
                        $filepath = $image;
                    }
                    // fix it later
                    // if (!$files->isUploadedFile())
                    // {
                    //     $this->flash->error('File hasn\'t been uploaded');
                    // }
                    $competition = new Competition();
                    $competition->assign($this->request->getPost(),['title', 'description', 'duedate']);
                    $competition->image = $filepath;

                    // make submission directory
                    $submission_folder = $competition->title . self::MARK . $competition->duedate;
                    if (!mkdir(BASE_PATH . self::SUBMISSION_PATH . $submission_folder)) {
                        $this->flashSession->error('Failed to create submission directory');
                        $this->response->redirect(['for' => 'challenge-manage-competition']);
                    }

                    // datepicker didn't work and need to convert,
                    // so I temporarily debug with this
                    // $date = explode("-",$competition->duedate);
                    // array_unshift($date, array_pop($date));
                    // $date = join("-",$date);
                    // $competition->duedate = $date;
                    if ($competition->save()){
                        $this->flashSession->success('Challenge has been created succesfully');
                        $this->response->redirect(['for' => 'challenge-manage-competition']);
                    } else {
                        foreach ($competition->getMessages() as $message)
                            $this->flash->error($message->getMessage());
                    }
                }else {
                    $this->flashSession->error('Your format image file is incorrect or have reach our size limit');
                    $this->response->redirect(['for' => 'challenge-manage-competition']);
                }
            }elseif ($this->request->getPost("edit")  && $this->security->checkToken()) {
                /*
                * Editing competition
                */
                $competition = Competition::findFirst($this->request->getPost('id'));
                if ($competition)
                {
                    if ($this->request->hasFiles())
                    {
                        $filepath = '';
                        $files = $this->request->getUploadedFiles();
                        foreach ($files as $file) {
                            // regex of this title need to be verified for pathfile later
                            $image = $this->request->getPost("title") . self::MARK . $file->getName();
                            $file->moveTo(
                                BASE_PATH . self::COMPETITION_PATH . $image
                            );
                            $filepath = $image;
                        }
                        // fix it later
                        // if (!$files->isUploadedFile())
                        // {
                        //     $this->flash->error('File hasn\'t been uploaded');
                        // }
                        // detachment image file at the web server
                        if (!unlink(BASE_PATH . self::COMPETITION_PATH . $competition->image)){
                            $this->flashSession->error('Failed to delete the old image poster');
                            $this->response->redirect(['for' => 'challenge-manage-competition']);
                        }
                        $competition->image = $filepath;
                        // datepicker didn't work and need to convert,
                        // so I temporarily debug with this
                        // $date = explode("-",$competition->duedate);
                        // array_unshift($date, array_pop($date));
                        // $date = join("-",$date);
                        // $competition->duedate = $date;
                    }
                    // rename submission directory and title and image poster
                    $old_submission_folder = $competition->title . self::MARK . $competition->duedate;
                    $old_title_image = $competition->image;
                    $competition->assign($this->request->getPost(),['title', 'description', 'duedate']);
                    $new_submission_folder = $competition->title . self::MARK . $competition->duedate;
                    // keep the image filename still
                    $old_image = explode(self::MARK, $competition->image);
                    $new_title_image = $competition->title . self::MARK . $old_image[1];
                    
                    // rename submission dir
                    if (!rename(BASE_PATH . self::SUBMISSION_PATH . $old_submission_folder,
                        BASE_PATH . self::SUBMISSION_PATH . $new_submission_folder))
                    {
                        $this->flashSession->error('Failed to migrate the entire submission directory');
                        $this->response->redirect(['for' => 'challenge-manage-competition']);
                    }
                    // rename image filename based on the title
                    if ($old_title_image != $new_title_image) {
                        if (!rename(BASE_PATH . self::COMPETITION_PATH . $old_title_image,
                            BASE_PATH . self::COMPETITION_PATH . $new_title_image))
                        {
                            $this->flashSession->error('Failed to migrate the image poster');
                            $this->response->redirect(['for' => 'challenge-manage-competition']);
                        }
                        $competition->image = $new_title_image;
                    }

                    if ($competition->update()){
                        $this->flashSession->success('Challenge has been edited succesfully');
                        $this->response->redirect(['for' => 'challenge-manage-competition']);
                    } else {
                        foreach ($competition->getMessages() as $message)
                            $this->flash->error($message->getMessage());
                    }
                }
            }elseif ($this->request->getPost("delete")  && $this->security->checkToken()) {
                /*
                * Deleting new competition
                */
                $competition = Competition::findFirst($this->request->getPost('id'));
                // delete submission directory
                $submission_folder = $competition->title . self::MARK . $competition->duedate;
                if (!$this->rrmdir(BASE_PATH . self::SUBMISSION_PATH . $submission_folder)) {
                    $this->flashSession->error('Failed to delete entire submission directory');
                    $this->response->redirect(['for' => 'challenge-manage-competition']);
                }

                // detachment image file at the web server
                $image = $competition->image;
                if (unlink(BASE_PATH . self::COMPETITION_PATH . $image) && $competition->delete())
                {
                    $this->flashSession->success('Challenge has been deleted succesfully');
                    $this->response->redirect(['for' => 'challenge-manage-competition']);
                } else {
                    foreach ($competition->getMessages() as $message)
                        $this->flash->error($message->getMessage());
                }
            }
        }
    }

    public function showAction()
    {
        /*
        * Read particular competition
        */
        $idcomp = $this->dispatcher->getParam('id');
        $competition = Competition::findFirst($idcomp);
        $title = $competition->title . ' - Submission Management';
        
        /*
        * Read all the submission
        */
        $this->view->submission = Submission::findByIdcomp($idcomp);
        $tricky_username = [];
        foreach ($this->view->submission as $s) {
            $username = explode(self::MARK, $s->files);
            $tricky_username[] = $username[0];
        }
        $this->view->setVars([
            'title' => $title,
            'competition_name' => $competition->title,
            'username' => $tricky_username
        ]);

        if ($this->request->isPost())
        {
            if ($this->request->getPost("delete") && $this->security->checkToken()) {
                /*
                * Deleting submission
                */
                $submission = Submission::findFirst([
                    'conditions' => 'id = :id: and idcomp = :idcomp:',
                    'bind' => [
                        'id' => $this->request->getPost("id"),
                        'idcomp' => $idcomp,
                    ]
                ]);
                $directory = $competition->title . self::MARK . $competition->duedate . "/";
                if (unlink(BASE_PATH . self::SUBMISSION_PATH . $directory . $submission->files) && $submission->delete())
                {
                    $this->flashSession->success('Submission has been deleted succesfully');
                    $this->response->redirect("/manage_competition/submission/" . $idcomp);
                } else {
                    foreach ($competition->getMessages() as $message)
                        $this->flash->error($message->getMessage());
                }
            }
        }
    }
}