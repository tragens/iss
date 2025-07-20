<?php

namespace App\Controllers;

class Home extends BaseController
{

    protected $db;
    protected $checklistModel;
    protected $councilModel;
    protected $facilityModel;
    protected $regionModel;
    protected $resultsModel;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->checklistModel = service('checklistModel');
        $this->councilModel = service('councilModel');
        $this->facilityModel = service('facilityModel');
        $this->regionModel = service('regionModel');
        $this->resultsModel = service('resultsModel');
    }



    public function index(): string
    {
        return view('home');
    }

    public function entry(): string
    {
        return view('entry');
    }

    public function fetchQuestions()
    {

        // Set content type
        $this->response->setHeader("Content-Type", "application/json");

        // Fetch all active
        $posts = $this->checklistModel->where(['parent'=> 0])->orWhere(['parent'=> null])->findAll();

        $subq = array_column($posts, 'id');
        $subItems = !empty($subq)
            ? $this->checklistModel->whereIn('parent', $subq)->findAll()
            : [];

        // 4. Group  items by Id
        $groupedItems = [];
        foreach ($subItems as $item) {
            $groupedItems[$item['parent']][] = $item;
        }


        if ($posts) {
            $response = array_map(function ($post) use ($groupedItems) {
                return [
                    'id'           => $post['id'],
                    'name'         => $post['name'],
                    'items'        => $groupedItems[$post['id']] ?? [],
                ];
            }, $posts);
        }

        return $this->response->setJSON($response);


    }

    public function report()
    {
        return view('report');
    }

    public function setup()
    {
        return view('setup');
    }


}
