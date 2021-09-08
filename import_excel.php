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
    private $voucher_no;
    private $voucher_type;
    private $roll_no;
    private $admission_no;
    private $total_amount;
    private $transaction_date;
    private $academic_year;
    private $due_amount;
    private $conc_amount;


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
                    // echo $this->getData[0];
                    // echo "-----------";
                    // if($this->loop_count == 0){
                    //     $this->loop_count++;
                    //     continue;
                    // }
                    // continue;
                    $this->sr = $this->getData[0];
                    $this->college_name = $this->getData[11];
                    $this->course_name = $this->getData[12];
                    $this->branch_name = $this->getData[13];
                    $this->batch_name = $this->getData[14];
                    $this->fee_category = $this->getData[10];
                    $this->fee_types = $this->getData[16];
                    $this->fee_collection_head = $this->getData[16];
                    $this->voucher_no = $this->getData[6];
                    $this->voucher_type = $this->getData[5];
                    $this->roll_no = $this->getData[7];
                    $this->admission_no = $this->getData[8];
                    $this->total_amount = $this->getData[18];
                    $this->transaction_date = $this->getData[1];
                    $this->academic_year = $this->getData[2];
                    $this->due_amount = $this->getData[17];
                    $this->conc_amount = $this->getData[19];


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


                    $this->query = "INSERT INTO financial_trans(voucher_no, voucher_type, roll_no, admission_no, total_amount, trans_date, acad_year, branch_id, due_amount, conc_amount) VALUES('$this->voucher_no','$this->voucher_type', '$this->roll_no', '$this->admission_no', '$this->total_amount', '$this->transaction_date', '$this->academic_year', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'), '$this->due_amount', '$this->conc_amount') ON DUPLICATE KEY UPDATE total_amount = total_amount+'$this->total_amount', due_amount = due_amount+'$this->due_amount', conc_amount = conc_amount+'$this->conc_amount'";
                    $this->response = $this->db->query($this->query);
                    if($this->response)
                    {
                        echo $this->sr . " --".$this->voucher_no;
                        echo "<br>";

                    }
                    else{
                        echo $this->sr . " --".$this->fee_types . "--------------Failed";
                        echo "<br>";
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