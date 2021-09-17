<?php

require_once 'database-connection.php';
require_once 'configure-database.php';

class import_sheet
{
    private $db;
    private $query;
    private $filename;
    private $file;
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
    private $remarks;
    private $module_cat;
    private $modules_id;


    public function __construct()
    {
        if(isset($_POST["import_excel"]))
        {        
            $this->filename = $_FILES["file"]["tmp_name"];
            if($_FILES["file"]["size"] > 0)
            {
                echo "<br>---------------------------------------------------<br>";
                $this->db = new db();
                $this->db = $this->db->database();
                $this->file = fopen($this->filename, "r");
                // print_r(fgetcsv($this->file, ","));       //Raw Data
                // echo "<br><br>";

                $this->academic = array('TUITION FEE', "Tuition Fees", 'Tuition Fee (Back Paper)', 'Tuition Fee (IBM ClaCCeC)', 'Tuition Fee (IBM Classes)', 'Tuition Fee Debarred', 'Tution Fees debarred paper');
                $this->academic_misc = array('Exam Fee', 'Exam Fee (Back Paper)', 'Exam Fee (CemeCter)', 'Exam Fee (Letral Deploma)', 'Exam Fee (Semester)', 'Exam Fee Debarred', 'Exam Fee ET Eligibility', 'Exam Fees', 'Exam Fees Back Paper', 'Exam Fees Debarred Paper', 'Degree Fees', 'Degree/Convocation/Certificate fee', 'Degree Fee', 'Convocation Fee Head', 'Training & Certification Fee', 'Thesis Fees', 'Student ID Fee Misc', 'Student ID Fee', 'Rechecking Fee', 'Library BookC Recieved', 'Library Books Recieved', 'Letral Fine Fee', 'Misc Exam Fees Back Paper', 'Online Registration Fine even Sem', 'Online Registration Fine odd Sem', 'Reckecking/Scrutiny Fee', 'Registration Fee', 'Registration FIne Even Sem', 'Registration Fine Odd Sem', 'Revaluation Fee', 'Special Backlog fee', 'Fine Fee', 'Adjustable Excess Fee', 'Adjusted_Amount', 'Ajustable_Excess_Amount', 'Excess Amount', 'OTHER FEES', 'Other Fee');
                $this->hostel = array('Hostel & Mess Fee');
                $this->hostel_misc = array('Security Fee', 'Indisciplinary Fine', 'Sport Activity Received');
                $this->transport = array('Travelling Fee');
                $this->transport_misc = array('Transport Fine', 'Bus Fine');


                $this->loop_count = 0;
                while(($this->getData = fgetcsv($this->file, ",")) !== FALSE)
                {
                    if($this->loop_count == 0){
                        $this->loop_count++;
                        continue;
                    }
                    $this->sr = $this->getData[0];
                    $this->transaction_date = $this->getData[1];
                    $this->academic_year = $this->getData[2];
                    $this->session = $this->getData[3]; // Same as Academic Year
                    $this->alloted = $this->getData[4];  //----------
                    $this->voucher_type = $this->getData[5];
                    $this->voucher_no = $this->getData[6];
                    $this->roll_no = $this->getData[7];
                    $this->admission_no = $this->getData[8];
                    $this->status = $this->getData[9];   //----------
                    $this->fee_category = $this->getData[10];
                    $this->college_name = $this->getData[11];
                    $this->course_name = $this->getData[12];
                    $this->branch_name = $this->getData[13];
                    $this->batch_name = $this->getData[14];
                    $this->receipt_no = $this->getData[15];
                    $this->fee_types = $this->getData[16];
                    $this->fee_collection_head = $this->getData[16];
                    $this->due_amount = $this->getData[17];
                    $this->total_amount = $this->getData[18];
                    $this->conc_amount = $this->getData[19];
                    $this->scholarship_amount = $this->getData[20];
                    $this->rev_conc_amount = $this->getData[21];
                    $this->write_off_amount = $this->getData[22];
                    $this->adjusted_amount = $this->getData[23];      //----------
                    $this->refund_amount = $this->getData[24];        //----------
                    $this->fund_transfer_amount = $this->getData[25];    //----------
                    $this->remarks = $this->getData[26];


                    if(in_array($this->fee_types,$this->academic)){
                        $this->module_cat = 'Academic';
                        $this->modules_id = 1;
                    }
                    else if(in_array($this->fee_types,$this->academic_misc)){
                        $this->module_cat = 'Academic Misc';
                        $this->modules_id = 2;
                    }
                    else if(in_array($this->fee_types,$this->hostel)){
                        $this->module_cat = 'Hostel';
                        $this->modules_id = 3;
                    }
                    else if(in_array($this->fee_types,$this->hostel_misc)){
                        $this->module_cat = 'Hostel Misc';
                        $this->modules_id = 4;
                    }
                    else if(in_array($this->fee_types,$this->transport)){
                        $this->module_cat = 'Transport';
                        $this->modules_id = 5;
                    }
                    else{
                        $this->module_cat = 'Transport Misc';
                        $this->modules_id = 6;
                    }

                
                    $this->query = "INSERT IGNORE INTO branches(college_name, course_name, branch_name, batch_name) VALUES('$this->college_name', '$this->course_name', '$this->branch_name', '$this->batch_name')";
                    $this->response = $this->db->query($this->query);

                    
                    $this->query = "INSERT INTO fee_category(fee_category, branch_id) VALUES('$this->fee_category', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'))";
                    $this->response = $this->db->query($this->query);

                    
                    $this->query = "INSERT IGNORE INTO fee_collection_type(module_category, fee_type_head, branch_id) VALUES('$this->module_cat', '$this->fee_types', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'))";
                    $this->response = $this->db->query($this->query);


                    $this->query = "INSERT INTO financial_trans(voucher_no, voucher_type, roll_no, admission_no, total_amount, trans_date, acad_year, branch_id, due_amount, conc_amount, scholarship_amount, rev_conc_amount, write_off_amount) VALUES('$this->voucher_no','$this->voucher_type', '$this->roll_no', '$this->admission_no', '$this->total_amount', '$this->transaction_date', '$this->academic_year', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'), '$this->due_amount', '$this->conc_amount', '$this->scholarship_amount', '$this->rev_conc_amount', '$this->write_off_amount') ON DUPLICATE KEY UPDATE total_amount = total_amount+'$this->total_amount', due_amount = due_amount+'$this->due_amount', conc_amount = conc_amount+'$this->conc_amount'";
                    $this->response = $this->db->query($this->query);
                    

                    $this->query = "INSERT INTO common_fee_collection(receipt_no, module_id, roll_no, admission_no, total_amount, branch_id,  acad_year, financial_year, trans_date) 
                    VALUES('$this->receipt_no', '$this->modules_id', '$this->roll_no', '$this->admission_no', '$this->total_amount', (SELECT branch_id FROM branches WHERE college_name='$this->college_name' AND course_name='$this->course_name' AND branch_name='$this->branch_name' AND batch_name='$this->batch_name'), '$this->academic_year', '$this->academic_year', '$this->transaction_date') ON DUPLICATE KEY UPDATE total_amount = total_amount+'$this->total_amount'";
                    $this->response = $this->db->query($this->query);
                }
                fclose($this->file);  

                $this->query = "INSERT INTO fee_types(fee_category_id, fee_category, fee_collection_id, fee_type_head, branch_id) SELECT fee_category.fee_category_id, fee_category.fee_category, fee_collection_type.fee_collection_id, fee_collection_type.fee_type_head, fee_collection_type.branch_id FROM fee_category, fee_collection_type WHERE fee_category.branch_id = fee_collection_type.branch_id";
                $this->response = $this->db->query($this->query);

                $this->file = fopen($this->filename, "r");
                $this->loop_count = 0;
                while(($this->getData = fgetcsv($this->file, ",")) !== FALSE)
                {
                    if($this->loop_count == 0){
                        $this->loop_count++;
                        continue;
                    }
                    $this->transaction_date = $this->getData[1];
                    $this->academic_year = $this->getData[2];
                    $this->voucher_type = $this->getData[5];
                    $this->voucher_no = $this->getData[6];
                    $this->roll_no = $this->getData[7];
                    $this->admission_no = $this->getData[8];
                    $this->fee_category = $this->getData[10];
                    $this->college_name = $this->getData[11];
                    $this->course_name = $this->getData[12];
                    $this->branch_name = $this->getData[13];
                    $this->batch_name = $this->getData[14];
                    $this->receipt_no = $this->getData[15];
                    $this->fee_types = $this->getData[16];
                    $this->fee_collection_head = $this->getData[16];
                    $this->due_amount = $this->getData[17];
                    $this->total_amount = $this->getData[18];
                    $this->conc_amount = $this->getData[19];
                    $this->scholarship_amount = $this->getData[20];
                    $this->rev_conc_amount = $this->getData[21];
                    $this->write_off_amount = $this->getData[22];
                    $this->remarks = $this->getData[26];

                    if(in_array($this->fee_types,$this->academic)){
                        $this->module_cat = 'Academic';
                        $this->modules_id = 1;
                    }
                    else if(in_array($this->fee_types,$this->academic_misc)){
                        $this->module_cat = 'Academic Misc';
                        $this->modules_id = 2;
                    }
                    else if(in_array($this->fee_types,$this->hostel)){
                        $this->module_cat = 'Hostel';
                        $this->modules_id = 3;
                    }
                    else if(in_array($this->fee_types,$this->hostel_misc)){
                        $this->module_cat = 'Hostel Misc';
                        $this->modules_id = 4;
                    }
                    else if(in_array($this->fee_types,$this->transport)){
                        $this->module_cat = 'Transport';
                        $this->modules_id = 5;
                    }
                    else{
                        $this->module_cat = 'Transport Misc';
                        $this->modules_id = 6;
                    }

                    $this->query = "INSERT IGNORE INTO financial_trans_details(f_t_id, amount, fee_types_id, branch_id, fee_type_head, remarks) VALUES(
                        (SELECT f_t_id FROM financial_trans WHERE voucher_no='$this->voucher_no'), 
                        '$this->total_amount', 
                        (SELECT fee_types.fee_types_id FROM fee_types INNER JOIN branches ON fee_types.branch_id = branches.branch_id WHERE branches.college_name='$this->college_name' AND branches.course_name = '$this->course_name' AND branches.branch_name='$this->branch_name' AND branches.batch_name='$this->batch_name' AND fee_types.fee_category = '$this->fee_category' AND fee_types.fee_type_head = '$this->fee_types' LIMIT 1), 
                        (SELECT fee_types.branch_id FROM fee_types INNER JOIN branches ON fee_types.branch_id = branches.branch_id WHERE branches.college_name='$this->college_name' AND branches.course_name = '$this->course_name' AND branches.branch_name='$this->branch_name' AND branches.batch_name='$this->batch_name' AND fee_types.fee_category = '$this->fee_category' AND fee_types.fee_type_head = '$this->fee_types' LIMIT 1), 
                        '$this->fee_types', 
                        '$this->remarks')";
                    $this->response = $this->db->query($this->query);


                    $this->query = "INSERT IGNORE INTO common_fee_collection_headwise(c_f_c_id, fee_types_id, module_id, fee_type_head, branch_id, amount) VALUES(
                        (SELECT c_f_c_id FROM common_fee_collection WHERE receipt_no='$this->receipt_no'), 
                        (SELECT fee_types.fee_types_id FROM fee_types INNER JOIN branches ON fee_types.branch_id = branches.branch_id WHERE branches.college_name='$this->college_name' AND branches.course_name = '$this->course_name' AND branches.branch_name='$this->branch_name' AND branches.batch_name='$this->batch_name' AND fee_types.fee_category = '$this->fee_category' AND fee_types.fee_type_head = '$this->fee_types' LIMIT 1), 
                        '$this->modules_id', 
                        (SELECT fee_types.fee_type_head FROM fee_types INNER JOIN branches ON fee_types.branch_id = branches.branch_id WHERE branches.college_name='$this->college_name' AND branches.course_name = '$this->course_name' AND branches.branch_name='$this->branch_name' AND branches.batch_name='$this->batch_name' AND fee_types.fee_category = '$this->fee_category' AND fee_types.fee_type_head = '$this->fee_types' LIMIT 1), 
                        (SELECT fee_types.branch_id FROM fee_types INNER JOIN branches ON fee_types.branch_id = branches.branch_id WHERE branches.college_name='$this->college_name' AND branches.course_name = '$this->course_name' AND branches.branch_name='$this->branch_name' AND branches.batch_name='$this->batch_name' AND fee_types.fee_category = '$this->fee_category' AND fee_types.fee_type_head = '$this->fee_types' LIMIT 1), 
                        '$this->total_amount')";
                    $this->response = $this->db->query($this->query);
                }

                $this->query = "ALTER TABLE fee_collection_type DROP COLUMN fee_type_head";
                $this->response = $this->db->query($this->query);
                fclose($this->file);  

                echo "<br>1) Added in the Branches table";
                echo "<br>2) Added in the Fee_Categoty table";
                echo "<br>3) Added in the Fee_Collection_Type table";
                echo "<br>4) Added in the Financial_Trans table";
                echo "<br>5) Added in the Common_Fee_Collection table";
                echo "<br>6) Added in the Fee_Types table";
                echo "<br>7) Added in the Financial_Trans_Details table";
                echo "<br>8) Added in the Common_Fee_Collection_Headwise table";
                echo "<br>---------------------------------------------------<br>";

                // echo `<form action="export_excel.php" method="post" name="export_data"><button type="submit" id="submit" name="export_excel">Export</button></form>`;
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
        unset($this->filename);
        unset($this->file);
        unset($this->sr);
        unset($this->transaction_date);
        unset($this->academic_year);
        unset($this->session);
        unset($this->alloted);
        unset($this->voucher_type);
        unset($this->voucher_no);
        unset($this->roll_no);
        unset($this->admission_no);
        unset($this->status);
        unset($this->fee_category);
        unset($this->college_name);
        unset($this->course_name);
        unset($this->branch_name);
        unset($this->batch_name);
        unset($this->receipt_no);
        unset($this->fee_types);
        unset($this->fee_collection_head);
        unset($this->due_amount);
        unset($this->total_amount);
        unset($this->conc_amount);
        unset($this->scholarship_amount);
        unset($this->rev_conc_amount);
        unset($this->write_off_amount);
        unset($this->adjusted_amount);
        unset($this->refund_amount);
        unset($this->fund_transfer_amount);
        unset($this->remarks);
    }
}

new import_sheet();

?>