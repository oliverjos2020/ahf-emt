<?php
class Facility extends dbobject
{
    public function create($data)
    {

    }

    public function getLGA($data)
    {
        $state = $data['state'];
        $sql = "SELECT * FROM lga WHERE State = '$state'";
        $lgas = $this->db_query($sql);
        $option = "";
        foreach($lgas as $lga){
            $option .= $lga['Lga'];
        }
        return $option;
        // return json_encode($lga);
    }
}