<?php

require_once 'drop-all.php';

    class config_db{
        private $db;
		private $query;
        public function __construct(){
            $this->db = new db();
            $this->db = $this->db->database();
            echo "<br>";

            if($this->db->query('SELECT * FROM branches LIMIT 1')){
                echo '1) Table for Branches already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE branches(
                    branch_id INT NOT NULL UNIQUE AUTO_INCREMENT,
                    college_name VARCHAR(100),
                    course_name VARCHAR(100),
                    branch_name VARCHAR(100),
                    batch_name VARCHAR(100),
                    PRIMARY KEY(college_name, course_name, branch_name, batch_name)
                )';
                if($this->db->query($this->query)){
                    echo '1) Table for Branches created successfully <br>';
                }
                else{
                    echo '1) Failed to create Branches table <br>';
                }
            }


            if($this->db->query('SELECT * FROM fee_category LIMIT 1')){
                echo '2) Table for Fee_Category already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE fee_category(
                    fee_category_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    fee_category VARCHAR(100),
                    branch_id INT NOT NULL UNIQUE
                )';
                if($this->db->query($this->query)){
                    echo '2) Table for Fee_Category created successfully <br>';
                }
                else{
                    echo '2) Failed to create Fee_Category table <br>';
                }
            }

            if($this->db->query('SELECT * FROM fee_collection_type LIMIT 1')){
                echo '3) Table for Fee_Collection_Type already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE fee_collection_type(
                    fee_collection_id INT NOT NULL UNIQUE AUTO_INCREMENT,
                    fee_type_head VARCHAR(100) NOT NULL,
                    module_category VARCHAR(100) NOT NULL,
                    branch_id BIGINT(10) NOT NULL,
                    PRIMARY KEY(fee_type_head, branch_id)
                )';
                if($this->db->query($this->query)){
                    echo '3) Table for Fee_Collection_Type created successfully <br>';
                }
                else{
                    echo '3) Failed to create Fee_Collection_Type table <br>';
                }
            }

            if($this->db->query('SELECT * FROM fee_types LIMIT 1')){
                echo '4) Table for Fee_Types already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE fee_types(
                    fee_types_id INT NOT NULL UNIQUE AUTO_INCREMENT,
                    fee_category_id BIGINT(10),
                    fee_category VARCHAR(100),
                    fee_collection_id BIGINT(10),
                    fee_type_head VARCHAR(100),
                    branch_id BIGINT(10) NOT NULL,
                    PRIMARY KEY(fee_types_id)
                )';
                if($this->db->query($this->query)){
                    echo '4) Table for Fee_Types created successfully <br>';
                }
                else{
                    echo '4) Failed to create Fee_Types table <br>';
                }
            }

            if($this->db->query('SELECT * FROM financial_trans LIMIT 1')){
                echo '5) Table for Financial_Trans already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE financial_trans(
                    f_t_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    voucher_no BIGINT(10) NOT NULL UNIQUE,
                    voucher_type VARCHAR(50),
                    roll_no VARCHAR(50),
                    admission_no VARCHAR(50),
                    total_amount BIGINT(15),
                    trans_date VARCHAR(20),
                    acad_year VARCHAR(50),
                    branch_id BIGINT(10),
                    due_amount BIGINT(10),
                    conc_amount BIGINT(10),
                    scholarship_amount BIGINT(10),
                    rev_conc_amount BIGINT(10),
                    write_off_amount BIGINT(10)
                )';
                if($this->db->query($this->query)){
                    echo '5) Table for Financial_Trans created successfully <br>';
                }
                else{
                    echo '5) Failed to create Financial_Trans table <br>';
                }
            }

            if($this->db->query('SELECT * FROM financial_trans_details LIMIT 1')){
                echo '6) Table for Financial_Trans_Details already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE financial_trans_details(
                    f_t_d_id INT NOT NULL UNIQUE AUTO_INCREMENT,
                    f_t_id BIGINT(10),
                    amount BIGINT(15),
                    fee_types_id BIGINT(15),
                    branch_id BIGINT(10),
                    fee_type_head VARCHAR(100),
                    remarks VARCHAR(300),
                    PRIMARY KEY(f_t_id, amount, fee_types_id, branch_id, fee_type_head)
                )';
                if($this->db->query($this->query)){
                    echo '6) Table for Financial_Trans_Details created successfully <br>';
                }
                else{
                    echo '6) Failed to create Financial_Trans_Details table <br>';
                }
            }

            if($this->db->query('SELECT * FROM common_fee_collection LIMIT 1')){
                echo '7) Table for Common_Fee_Collection already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE common_fee_collection(
                    c_f_c_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    receipt_no BIGINT(10) NOT NULL UNIQUE,
                    roll_no VARCHAR(50),
                    admission_no VARCHAR(50),
                    total_amount BIGINT(15),
                    branch_id BIGINT(10),
                    acad_year VARCHAR(50),
                    financial_year VARCHAR(50),
                    trans_date VARCHAR(20)
                )';
                if($this->db->query($this->query)){
                    echo '7) Table for Common_Fee_Collection created successfully <br>';
                }
                else{
                    echo '7) Failed to create Common_Fee_Collection table <br>';
                }
            }

            if($this->db->query('SELECT * FROM common_fee_collection_headwise LIMIT 1')){
                echo '8) Table for Common_Fee_Collection_Headwise already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE common_fee_collection_headwise(
                    c_f_c_h_id INT NOT NULL UNIQUE AUTO_INCREMENT,
                    c_f_c_id BIGINT(10),
                    fee_types_id BIGINT(15),
                    fee_type_head VARCHAR(100),
                    branch_id BIGINT(10),
                    amount BIGINT(15),
                    PRIMARY KEY(c_f_c_id, fee_types_id, fee_type_head, branch_id, amount)
                )';
                if($this->db->query($this->query)){
                    echo '8) Table for Common_Fee_Collection_Headwise created successfully <br>';
                }
                else{
                    echo '8) Failed to create Common_Fee_Collection_Headwise table <br>';
                }
            }

            if($this->db->query('SELECT * FROM modules LIMIT 1')){
                echo '9) Modules already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE modules(
                    module_id INT NOT NULL UNIQUE AUTO_INCREMENT,
                    module_cat_id BIGINT(10),
                    module_sub_category VARCHAR(100),
                    module_category VARCHAR(100),
                    PRIMARY KEY(module_id))';
                if($this->db->query($this->query)){
                    $this->module_category = ['Academic', 'Academic Misc', 'Hostel', 'Hostel Misc', 'Transport', 'Transport Misc'];
                    $this->module_sub_category = [
                        ['TUITION FEE', 'Tuition Fees', 'Tuition Fee (Back Paper)', 'Tuition Fee (IBM ClaCCeC)', 'Tuition Fee (IBM Classes)', 'Tuition Fee Debarred', 'Tution Fees debarred paper'],
                        ['Exam Fee', 'Exam Fee (Back Paper)', 'Exam Fee (CemeCter)', 'Exam Fee (Letral Deploma)', 'Exam Fee (Semester)', 'Exam Fee Debarred', 'Exam Fee ET Eligibility', 'Exam Fees', 'Exam Fees Back Paper', 'Exam Fees Debarred Paper', 'Degree Fees', 'Degree/Convocation/Certificate fee', 'Degree Fee', 'Convocation Fee Head', 'Training & Certification Fee', 'Thesis Fees', 'Student ID Fee Misc', 'Student ID Fee', 'Rechecking Fee', 'Library BookC Recieved', 'Library Books Recieved', 'Letral Fine Fee', 'Misc Exam Fees Back Paper', 'Online Registration Fine even Sem', 'Online Registration Fine odd Sem', 'Rechecking/Scrutiny Fee', 'Registration Fee', 'Registration FIne Even Sem', 'Registration Fine Odd Sem', 'Revaluation Fee', 'Special Backlog fee', 'Fine Fee', 'Adjustable Excess Fee', 'Adjusted_Amount', 'Ajustable_Excess_Amount', 'Excess Amount', 'OTHER FEES', 'Other Fee'],
                        ['Hostel & Mess Fee'],
                        ['Security Fee', 'Indisciplinary Fine', 'Sport Activity Received'],
                        ['Travelling Fee'],
                        ['Transport Fine', 'Bus Fine']
                    ];
                    for($this->i=0; $this->i<count($this->module_category); $this->i++)
                    {
                        for($this->j=0; $this->j<count($this->module_sub_category[$this->i]); $this->j++)
                        {
                            $this->x = $this->module_sub_category[$this->i][$this->j];
                            $this->y = $this->module_category[$this->i];
                            $this->query = "INSERT INTO modules(module_cat_id, module_sub_category, module_category) VALUES('$this->i', '$this->x', '$this->y')";
                            $this->db->query($this->query);
                        }
                    }
                    echo '9) Table for Modules created successfully <br>';
                }
                else{
                    echo '9) Failed to create Modules table <br>';
                }
            }
            $this->db->close();
        }
    }
    new config_db();

    ?>
  