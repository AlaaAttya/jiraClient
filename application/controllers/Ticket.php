<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ticket
 *
 * @author alaaattya
 */
class Ticket extends CI_Controller {

    public function create() {
        $this->load->view('createTicketForm.php');
    }

    public function submit() {
        if (isset($_POST['submitIssue'])) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $projectUrl = $this->input->post('projectUrl');
            $projectId = $this->input->post('projectId');
            $projectName = $this->input->post('projectName');


            $issueDesc = $this->input->post('issueDesc');
            $issueSummary = $this->input->post('issueSummary');

            $assigneeName = $this->input->post('assigneeName');

            $filename = $this->input->post('upfile');

            /*var_dump($_FILES["upfile"]);
            echo "<br>";
            var_dump($_FILES["upfile"]["type"]);
*/

            $info = pathinfo($_FILES['upfile']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = rand('0', '100000000')."." . $ext;

            $target = 'images/' . $newname;
            move_uploaded_file($_FILES['upfile']['tmp_name'], $target);

           
            $result = $this->sendAPIRequest($username, $password, $issueDesc, $projectName, $projectId, $projectUrl, $issueSummary, $issueDesc, $assigneeName);

            //var_dump($result);exit;
            //var_dump($result);            
            //$issueId = $result['id'];
            chmod('/var/www/jiraClient/images/'.$newname, 777);
            $this->addAttachment('/var/www/jiraClient/images/'.$newname , $result['id'], $projectUrl, $username, $password);
        } else {
            echo 'you are not allowed to be here dude!';
        }
    }

    private function sendAPIRequest($username, $password, $issueDesc, $projectName, $projectId, $projectUrl, $issueSummary, $issueDesc, $assigneeName) {


        $url = "$projectUrl/rest/api/2/issue/";

        $data = array(
            'fields' => array(
                'project' => array(
                    'key' => $projectName,
                    'id' => $projectId
                ),
                "assignee" => array("name" => "$assigneeName",
                    //"type" => "net.astarapps.atlassian.user.alaa",
                    "value" => array("displayName" => "$assigneeName",
                        "name" => "alaa",
                    // "self" => "http://localhost:8090/jira/rest/api/2.0.alpha1/user?username=admin"
                    )
                )
                ,
                'summary' => $issueSummary,
                'description' => $issueDesc,
                "issuetype" => array(
                    "name" => "Task"
                ),
            ),
        );

        $ch = curl_init();

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json'
        );



        $test = "This is the content of the custom field.";



        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");



        $result = curl_exec($ch);

        $ch_error = curl_error($ch);



        if ($ch_error) {

            echo "cURL Error: $ch_error";
        } else {

            return json_decode($result, TRUE);
        }



        curl_close($ch);
    }

    private function addAttachment($filename, $issueId, $projectUrl, $username, $password) {
        /* $username = 'alaa';
          $password = 'testing'; */
        $url = "$projectUrl/rest/api/2/issue/$issueId/attachments";

        $data = array(
            'file' => "@" . $filename
        );

        $ch = curl_init();
        $boundary = '--myboundary-xxx';
        $headers = array(
            "X-Atlassian-Token: nocheck",
            'Content-Type: multipart/form-data',
            'boundary: $boundary'
        );

//$body = multipart_build_query($data, $boundary);
        /* curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($ch, CURLOPT_VERBOSE, 1);
          //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

          curl_setopt($ch, CURLOPT_URL, $url);

          curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
         */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $result = curl_exec($ch);

        $ch_error = curl_error($ch);



        if ($ch_error) {

            echo "cURL Error: $ch_error";
        } else {

            echo $result;
        }



        curl_close($ch);
    }

    public function test() {
        $url = "https://astarapps.atlassian.net/rest/api/2/project/TEST/";

        $ch = curl_init();

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json'
        );



        $test = "This is the content of the custom field.";



        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_URL, $url);

        // curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");



        $result = curl_exec($ch);

        $ch_error = curl_error($ch);



        if ($ch_error) {

            echo "cURL Error: $ch_error";
        } else {

            echo $result;
        }



        curl_close($ch);
    }

}
