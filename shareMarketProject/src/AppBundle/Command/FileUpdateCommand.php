<?php

namespace AppBundle\Command;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileUpdateCommand extends ContainerAwareCommand
{
    /**
     * Method to configure the console command
     * 
     */

    protected function configure()
    {
        $this
            ->setName('file:update')
            ->setDescription('update the instrument value');
    }

    /**
     * Method to excute the code based on the configure command
     * 
     */

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $historyFileArray = array(
            'ABBA' => 'ABBA_history.txt',
            'HODL5' => 'HODL5_history.txt',
            'CCALT' => 'CCALT_history.txt'
        );
        foreach ($historyFileArray as $historyFile) {
            if ($data = $this->getDateAndValue($historyFile)) {
                if ($this->checkData($data['date'], $historyFile)) {
                    echo " Data already present \n";
                } else {
                    $this->updateData($historyFile, $data);
                    echo " Data Updated Successfully \n";
                }
            } else { 
                echo "Date is expired \n";
             }
        }
    }

    /**
     * Method to get the database connection
     * 
     * @return connection
     */

    public function getDBConnection()
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        return $em->getConnection();
    }

    /**
     * Method to get the date and value
     * 
     * @param $fileName
     * 
     * @return Array
     */

    public function getDateAndValue($historyFile)
    {
        $container = $this->getContainer();
        $historydata = file($container->getParameter('file_path') . $historyFile);
        $lastEntity = $historydata[count($historydata) - 1];
        $historydata = explode(";", $lastEntity);
        $historyDate = substr($historydata[0], 0, 4) . '-' . substr($historydata[0], 4, 2) . '-' . substr($historydata[0], 6, 2);
        $historydata = array(
            "date" => $historyDate,
            "value" => $historydata[1]
        );
        $result = ($this->checkHistoryDate($historyDate)) ? $historydata : null;
        return $result;
    }

    /**
     * Method to check the data is present in the database
     * 
     * @param $data
     * @param $file
     * 
     * @return Boolean
     */

    public function checkData($historyDate, $historyFile)
    {
        $connection = $this->getDBConnection();
        $id = $this->getId($historyFile);
        $statement = $connection->prepare("select instrument_id from instrument_history where date = '$historyDate' and instrument_id ='$id'");
        $statement->execute();
        $result = ($statement->fetchAll()) ? true : false;
        return $result;
    }

    /**
     * Method to check the data is present in the database
     * 
     * @param $data
     * @param $file
     * 
     * @return Boolean
     */

    public function updateData($historyFile, $historyData)
    {
        $connection = $this->getDBConnection();
        $statement = $connection->prepare("insert into instrument_history values(null,:date,:value,:id)");
        $statement->bindValue('id', $this->getId($historyFile));
        $statement->bindValue('date', $historyData['date']);
        $statement->bindValue('value', (float) $historyData['value']);
        $result = ($statement->execute()) ? true : false;
        return $result;
    }

    /**
     * Method to return the id based on fileName
     * @param $historyFile
     * 
     * @return Integer
     */

    public function getId($historyFile)
    {
        $connection = $this->getDBConnection();
        $getId = $connection->prepare("select id from instrument where file_name = '$historyFile'");
        $getId->execute();
        $result = $getId->fetchAll();
        return $result[0]['id'];
    }

    public function checkHistoryDate($historyDate)
    {
        $result = ($historyDate === (date('Y-m-d', strtotime("-1 days")))) ? true : false;
        return $result;
    }
}
