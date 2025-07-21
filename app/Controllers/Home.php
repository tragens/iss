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
    protected $resultitemModel;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->checklistModel = service('checklistModel');
        $this->councilModel = service('councilModel');
        $this->facilityModel = service('facilityModel');
        $this->regionModel = service('regionModel');
        $this->resultsModel = service('resultsModel');
        $this->resultitemModel = service('resultitemModel');
    }



    public function index(): string
    {
        return view('home');
    }

    public function entry(): string
    {
        $data['region'] = $this->regionModel->findAll();
        $data['council'] = $this->councilModel->findAll();
        $data['facility'] = $this->facilityModel->findAll();
        return view('entry', $data);
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

    public function entrySave()
    {
        $this->db->transBegin();

        try {
            $json = $this->request->getJSON(true); // associative array

            $region   = $json['region'] ?? null;
            $council  = $json['council'] ?? null;
            $facility = $json['facility'] ?? null;
            $entries  = $json['entries'] ?? [];

            // Save the main result group
            $groupData = [
                'date'      => date('Y-m-d'),
                'region'    => $region,
                'council'   => $council,
                'facility'  => $facility,
                'createdBy' => 0,
            ];

            $resultId = $this->resultsModel->insert($groupData);
            if (!$resultId) {
                $error = $this->resultsModel->error();
                throw new \Exception("Failed to insert group data. ({$error['message']})");
            }

            // Save individual result items
            foreach ($entries as $entry) {

                // if (!isset($entry['checklistId'], $entry['results'], $entry['maxScore'])) {
                //     throw new \Exception("Missing required entry fields.". var_dump($entry));
                // }

                $itemsData = [
                    'resultId'    => $resultId,
                    'checklistId' => $entry['checklistId'],
                    'results'     => $entry['results'],
                    'maxScore'    => $entry['maxScore'],
                    'comment'     => $entry['comment'] ?? '',
                ];

                $insert = $this->resultitemModel->insert($itemsData);
                if (!$insert) {
                    $error = $this->resultitemModel->error();
                    throw new \Exception("Failed to insert item data. ({$error['message']})");
                }
            }

            $this->db->transCommit();

            return $this->response->setJSON([
                'statusCode' => 200,
                'message' => "Data inserted successfully",
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function fetchEntry()
    {

        // Set content type
        $this->response->setHeader("Content-Type", "application/json");

        // Fetch all active
        $posts = $this->resultsModel
                        ->select('tb_results.id, tb_facility.name as facility, tb_results.date, sum(tb_resultitem.maxScore) as maxScore, sum(tb_resultitem.results) as score')
                        ->join('tb_facility', 'tb_facility.id = tb_results.facility')
                        ->join('tb_resultitem', 'tb_resultitem.resultId = tb_results.id')
                        ->groupBy('tb_results.id')
                        ->findAll();

        if ($posts) {
            $response = array_map(function ($post) {
                return [
                    'id'       => $post['id'],
                    'facility' => $post['facility'],
                    'date'     => $post['date'],
                    'maxScore' => $post['maxScore'],
                    'score'    => $post['score']
                ];
            }, $posts);
        }

        return $this->response->setJSON($posts);

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
