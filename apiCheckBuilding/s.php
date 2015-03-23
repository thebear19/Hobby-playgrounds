<?php
class BuildingService
{
	public $BuildingData;
	public $Result;	
	public function getBuildingData($parameters) 
	{
	  include ('connect.php');
	  $show = mysql_query("SELECT * FROM building WHERE Application_Date='".$parameters->YYYY."-".$parameters->MM."-".$parameters->DD."'",$con);
	  $i=0;
	  $param[] = new BuildingService();
	  while($row = mysql_fetch_assoc($show))
	  {
		  $param[$i]->BuildingData = "<tr>
		  				<td>".$row['Application_Permit_Number']."</td>
		  				<td>".$row['Permit_Type']."</td>
						<td>".$row['Address']."</td>
						<td>".$row['Description']."</td>
						<td>".$row['Category']."</td>
						<td>".$row['Action_Type']."</td>
						<td>".$row['Work_Type']."</td>
						<td>".$row['Value']."</td>
						<td>".$row['Applicant_Name']."</td>
						<td>".$row['Application_Date']."</td>
						<td>".$row['Issue_Date']."</td>
						<td>".$row['Final_Date']."</td>
						<td>".$row['Expiration_Date']."</td>
						<td>".$row['Status']."</td>
						<td>".$row['Permit_and_Complaint_Status_URL']."</td>
						<td>".$row['Latitude']."</td>
						<td>".$row['Longitude']."</td>
						<td>".$row['Location']."</td>
						</tr>";
		  $i++;
	  }
	  return $param;
	}
	public function CreateBuildingData($parameters)
	{
		include ('connect.php');
		$show = mysql_query("SELECT * FROM building WHERE Application_Permit_Number='".$parameters->Checker."'",$con);
		$row = mysql_num_rows($show);
		$param = new BuildingService();
		if($row == 0)
		{
			mysql_query("INSERT INTO building (Application_Permit_Number,Permit_Type,Address,Description,Category,Action_Type,Work_Type,Value,Applicant_Name,Application_Date,Issue_Date, Final_Date,Expiration_Date,Status,Permit_and_Complaint_Status_URL,Latitude,Longitude,Location) 
			VALUES (".$parameters->BuildingDetail."
)",$con) or die(mysql_error());
			$param->Result = "<center><h3><font color='.#33CC33.'>Create Completed</font></h3></center>";
		}
		else{$param->Result = "<center><h3><font color='.#FF3333.'>Can't Create because Have data yet</font></h3></center>";}
		return $param;
	}
	public function UpdateBuildingData($parameters)
	{
		include ('connect.php');
		$show = mysql_query("SELECT * FROM building WHERE Application_Permit_Number='".$parameters->Checker."'",$con);
		$row = mysql_num_rows($show);
		$param = new BuildingService();
		if($row == 1)
		{
			mysql_query("UPDATE building SET ".$parameters->BuildingDetail." WHERE Application_Permit_Number='".$parameters->Checker."'",$con) or die(mysql_error());
			$param->Result = "<center><h3><font color='.#33CC33.'>Update Completed</font></h3></center>";
		}
		else{$param->Result = "<center><h3><font color='.#FF3333.'>Can't Update because Not have data</font></h3></center>";}
		return $param;
	}
	public function DeleteBuildingData($parameters)
	{
		include ('connect.php');
		$show = mysql_query("SELECT * FROM building WHERE Application_Permit_Number='".$parameters->BuildingDataID."'",$con);
		$row = mysql_num_rows($show);
		$param = new BuildingService();
		if($row >= 1)
		{
			mysql_query("DELETE FROM building WHERE Application_Permit_Number='".$parameters->BuildingDataID."'",$con) or die(mysql_error());
			$param->Result = "<center><h3><font color='.#33CC33.'>Delete Completed</font></h3></center>";
		}
		else{$param->Result = "<center><h3><font color='.#FF3333.'>Can't Delete Data because Not have or Input Mistake</font></h3></center>";}
		return $param;
	}
}
 
try
{
	$server = new SOAPServer("t.wsdl");
	$server->setClass('BuildingService');
	$server->handle();
}
 
catch (SOAPFault $f)
{
  print $f->faultstring;
}
?>