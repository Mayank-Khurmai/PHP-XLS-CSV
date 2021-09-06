<?php

require_once __DIR__.'/database-connection.php';

    class config_db{
        private $db;
		private $query;
        public function __construct(){
            $this->db = new db();
            $this->db = $this->db->database();

            if($this->db->query('SELECT * FROM branches LIMIT 1')){
                echo '1) Table for Branches already exists <br>';
            }
            else{
                $this->query = 'CREATE TABLE branches(
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    college_name VARCHAR(50),
                    course_name VARCHAR(50),
                    branch_name VARCHAR(50)
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(40) NOT NULL UNIQUE,
                    otp INT(6) DEFAULT 0,
                    count INT(5) DEFAULT 0,
                    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                )';
                if($this->db->query($this->query)){
                    echo '8) Table for Common_Fee_Collection_Headwise created successfully <br>';
                }
                else{
                    echo '8) Failed to create Common_Fee_Collection_Headwise table <br>';
                }
            }

            $this->db->close();
        }
    }

    new config_db();

    ?>
  