<?php
class InstrumentHistory
{
    /**
     * Method to connect the database
     *
     * @return connection
     */
    function connect()
    {
        $connection = mysqli_connect("localhost", "root", "password", "ShareMarket");
        return $connection;
    }

    /**
     * Method to download the file from database
     */

    function downloadFile()
    {
        foreach ($this->historyFileArray() as $historyFile)
        {
            $result = mysqli_query($this->connect() , "SELECT data FROM mv_file WHERE name = '$historyFile'");
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $content = $res[0]['data'];
            /*$fp      = fopen("/var/www/public/FileReader/HistoryFiles/" . $historyFile, "wb");
            fwrite($fp, $content);
            fclose($fp);*/
            $this->getDateAndValue($historyFile);
        }
    }

    /**
     * Method to get the date and history value from the downloaded file
     *
     */

    function getDateAndValue($historyFile)
    {
        $historyData = file("/var/www/public/FileReader/HistoryFiles/" . $historyFile);
        $lastEntity = $historyData[count($historyData) - 1];
        $historyData = explode(";", $lastEntity);
        $historyDate = substr($historyData[0], 0, 4) . '-' . substr($historyData[0], 4, 2) . '-' . substr($historyData[0], 6, 2);
        $historyData = array(
            "date" => $historyDate,
            "value" => $historyData[1]
        );
        $this->updateValue($historyData, $historyFile);
    }

    /**
     * Method return the list of history files in a array
     *
     * @return Array
     */

    function historyFileArray()
    {
        $historyFileArray = array(
            'HODL5' => 'HODL5_history.txt',
            'CCMIX' => 'CCMIX_history.txt'
        );
        return $historyFileArray;
    }

    /**
     * Method to update the check the value is present in the database
     *
     */

    function updateValue($historyData, $historyFile)
    {
        if ($this->checkDate($historyData, $historyFile))
        {
            echo "Data already updated...\n";
        }
        else
        {
            $this->updateData($historyData, $historyFile);
        }
    }

    /**
     * Method to get the Id based on file name
     *
     * @return Integer
     */

    function getId($historyFile)
    {
        $historyData = explode("_", $historyFile);
        $result = mysqli_query($this->connect() , "SELECT id FROM mv_instrument WHERE symbol = '$historyData[0]'");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $result[0]['id'];
    }

    /**
     * Method to check the value based on the date
     *
     * @return Boolean
     */

    function checkDate($historyData, $historyFile)
    {
        $id = $this->getId($historyFile);
        $result = mysqli_query($this->connect() , "SELECT high FROM mv_instrument_ohlc_eod WHERE instrumentId = '$id' and date = '$historyData[date]'");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return ($result != null) ? true : false;
    }

    /**
     * Method to update the date and value in the database
     */

    function updateData($historyData, $historyFile)
    {
        $instrumentId = $this->getId($historyFile);
        $historyValue = (float)$historyData['value'];
        $connect = $this->connect();
        $statement = $connect->prepare("insert into mv_instrument_ohlc_eod values($instrumentId,'$historyData[date]', $historyValue, $historyValue, $historyValue, $historyValue)");
        if ($statement->execute())
        {
            echo "Value updated successfully..\n";
        }
        else
        {
            echo mysqli_error($connect);
        }
    }
}
$instrumentHistory = new InstrumentHistory;
$instrumentHistory->downloadFile();

?>
