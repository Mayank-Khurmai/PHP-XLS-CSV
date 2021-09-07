<?php

require_once 'database-connection.php';

class import_sheet
{
    private $db;
    private $query;
    private $filename;
    private $file;
    private $response;
    private $loop_count;
    private $college_name;
    private $course_name;
    private $branch_name;
    private $batch_name;
    private $fee_category;
    private $fee_types;
    private $fee_collection_head;


    public function __construct()
    {
        if(isset($_POST["import_excel"]))
        {        
            $this->filename = $_FILES["file"]["tmp_name"];
            if($_FILES["file"]["size"] > 0)
            {
                $this->db = new db();
                $this->db = $this->db->database();
                $this->file = fopen($this->filename, "r");
                print_r(fgetcsv($this->file, ","));       //Raw Data
                echo "<br><br>";
                $this->loop_count = 0;
                while(($this->getData = fgetcsv($this->file, ",")) !== FALSE)
                {
                    if($this->loop_count == 0){
                        $this->loop_count++;
                        continue;
                    }
                    // continue;
                    $this->college_name = $this->getData[11];
                    $this->course_name = $this->getData[12];
                    $this->branch_name = $this->getData[13];
                    $this->batch_name = $this->getData[14];
                    $this->fee_category = $this->getData[10];
                    $this->fee_types = $this->getData[16];
                    $this->fee_collection_head = $this->getData[16];


                    $this->query = "INSERT IGNORE INTO branches(college_name, course_name, branch_name, batch_name) VALUES('$this->college_name', '$this->course_name', '$this->branch_name', '$this->batch_name')";
                    $this->response = $this->db->query($this->query);
                    if($this->response)
                    {
                        // echo $this->getData[0];
                        // echo "<br>";
                    }
                    else{
                        // echo $this->getData[0] . "--------------Failed";
                        // echo "<br>";
                    }

                    

                    $this->query = "INSERT IGNORE INTO fee_category(fee_category, branch_id) VALUES('$this->fee_category', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'))";
                    $this->response = $this->db->query($this->query);
                    if($this->response)
                    {
                        // echo $this->fee_category;
                        // echo "<br>";
                    }
                    else{
                        // echo $this->fee_category . "--------------Failed";
                        // echo "<br>";
                    }

                    
                    $this->query = "INSERT IGNORE INTO fee_collection_type(fee_type_head, branch_id) VALUES('$this->fee_collection_head', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'))";
                    $this->response = $this->db->query($this->query);
                    if($this->response)
                    {
                        // echo $this->fee_types;
                        // echo "<br>";
                    }
                    else{
                        // echo $this->fee_types . "--------------Failed 2";
                        // echo "<br>";
                    }
                }
                    $this->query = "INSERT INTO fee_types(fee_category_id, fee_category, fee_collection_id, fee_type_head, branch_id) SELECT fee_category.fee_category_id, fee_category.fee_category, fee_collection_type.fee_collection_id, fee_collection_type.fee_type_head, fee_collection_type.branch_id FROM fee_category, fee_collection_type WHERE fee_category.branch_id = fee_collection_type.branch_id";
                    $this->response = $this->db->query($this->query);
                    if($this->response)
                    {
                        echo $this->fee_types;
                        echo "<br>";
                    }
                    else{
                        echo $this->fee_types . "--------------Failed";
                        echo "<br>";
                    }
                fclose($this->file);  
            }
            else{
                echo "Invalid File : File size < 1 Kb";
            }
        }  
        else
        {
            echo "Invalid File : File not Selected";
        }
        
        $this->db->close();
    }

    public function __destruct()
    {
        unset($this->db);
        unset($this->query);
        unset($this->user_mail);
    }
}

new import_sheet();

?>