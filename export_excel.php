<?php

require_once 'database-connection.php';

class export_sheet
{
    private $db;
    private $query;
    private $output;
    private $data;


    public function __construct()
    {
        if(isset($_POST["export_excel"]))
        {        
            $this->db = new db();
            $this->db = $this->db->database();

            
            header('Content-Type: text/csv; charset=utf-8');  
            header('Content-Disposition: attachment; filename=data.csv');  
            $output = fopen("php://output", "w");  
            
            fputcsv($this->output, array('Branch ID', 'College Name'));  



            $this->query = 'SELECT branch_id, college_name from branches ORDER BY branch_id';
            $this->response = $this->db->query($this->query);
            while($this->data = $this->response->fetch_assoc()){
                fputcsv($this->output, $this->data); 
            }
            fclose($this->output);
        }  
        else
        {
            echo "Error";
        }
        
        $this->db->close();
    }

    public function __destruct()
    {
        unset($this->db);
        unset($this->query);
    }
}

new export_sheet();

?>