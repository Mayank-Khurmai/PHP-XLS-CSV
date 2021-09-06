<?php

require_once 'database-connection.php';

class import_sheet
{
    private $db;
    private $query;
    private $filename;
    private $file;
    private $response;
    private $college_name;
    private $course_name;
    private $branch_name;

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
                // print_r(fgetcsv($this->file, ","));       //Raw Data
                while(($this->getData = fgetcsv($this->file, ",")) !== FALSE)
                {
                    $this->college_name = $this->getData[11];
                    $this->course_name = $this->getData[12];
                    $this->branch_name = $this->getData[13];
                    $this->query = "INSERT IGNORE INTO branches(college_name, course_name, branch_name) VALUES('$this->college_name', '$this->course_name', '$this->branch_name')";
                    $this->response = $this->db->query($this->query);
                    if($this->response)
                    {
                        echo $this->getData[0];
                        echo "<br>";
                    }
                    else{
                        echo $this->getData[0] . "--------------Failed";
                        echo "<br>";
                    }
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
        

        
        //     $this->query->bind_param('s',$this->user_mail);
        //     $this->query->execute();
        //     if($this->query->affected_rows!=0){
        //         echo 'Added Successfully';
        //     }
        //     else{
        //         echo 'Please try Again';
        //     }
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