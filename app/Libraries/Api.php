<?php

namespace App\Libraries;

class Api
{
    public $BaseUrl = 'http://localhost:8000/';

    public $jwtToken = null;


    public function post($service, $data)
    {

        $curl = curl_init();

        $options = array(
            CURLOPT_URL => $this->BaseUrl . "{$service}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data
        );
        if ($this->jwtToken != null)
            $options[CURLOPT_HTTPHEADER] = array("Authorization: Bearer " . $this->jwtToken);

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function get($service, $param = null)
    {
        $curl = curl_init();
        // echo $this->BaseUrl . "{$service}?{$param} <br/>";
        $options = array(
            CURLOPT_URL => $this->BaseUrl . "{$service}?{$param}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        );

        if ($this->jwtToken != null)
            $options[CURLOPT_HTTPHEADER] = array("Authorization: Bearer " . $this->jwtToken);

        curl_setopt_array($curl, $options);


        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function delete($service)
    {

        $curl = curl_init();
        $options = array(
            CURLOPT_URL => $this->BaseUrl . "{$service}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
        );
        if ($this->jwtToken != null)
            $options[CURLOPT_HTTPHEADER] = array("Authorization: Bearer " . $this->jwtToken);
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function put($service, $data, $opt = null)
    {

        $curl = curl_init();

        $options = array(
            CURLOPT_URL => $this->BaseUrl . "{$service}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => arrayToGet($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        );
        if (is_array($opt))
            $options = array_merge($options, $opt);

        if ($this->jwtToken != null)
            $options[CURLOPT_HTTPHEADER] = array("Authorization: Bearer " . $this->jwtToken);
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}
