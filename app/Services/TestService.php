<?php

namespace App\Services;

use App\Models\Test;

class TestService
{
    public function store(array $data)
    {
        $answers = str_split($data['answers']);
        $result = [];

        for ($i = 0; $i < count($answers); $i += 2) {
            $result[$answers[$i]] = $answers[$i + 1];
        }

        $data['answers'] = json_encode($result);
        $data['test_code'] = rand(100000, 999999);
        Test::create($data);
    }
}