<?php

class htmlTable
{

    static public function displayAllRecords($tableRecords)
    {
        echo "<table  border=\"3\">";

        echo "<tr>
                <th>ID</th>
                <th>OwnerEmail</th>
                <th>OwnerID</th>
                <th>Create Date</th>
                <th>Due Date</th>
                <th>Message</th>
                <th>ISDone</th>
        </tr>";

        foreach($tableRecords as $key=>$row) {
            echo "<tr>";
            foreach($row as $key2=>$row2){
                echo "<td>" . $row2 . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }


    static public function displayOneRecord($tableRecord)
    {
        echo "<table  border=\"3\">";

        echo "<tr>
                <th>ID</th>
                <th>OwnerEmail</th>
                <th>OwnerID</th>
                <th>Create Date</th>
                <th>Due Date</th>
                <th>Message</th>
                <th>ISDone</th>
        </tr>";

            echo "<tr>";

            foreach($tableRecord as $key2=>$row2){
                  echo "<td>" . $row2 . "</td>";
           }
            echo "</tr>";

        echo "</table>";
    }
}

?>