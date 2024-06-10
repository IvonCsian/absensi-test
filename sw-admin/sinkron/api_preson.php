<?PHP session_start();
header('Content-Type: application/json');

require_once'../../sw-library/sw-config.php'; 
include_once'../../sw-library/sw-function.php';
	$salt 			= '$%DSuTyr47542@#&*!=QxR094{a911}+';
	$ip_login 		= $_SERVER['REMOTE_ADDR'];
	$created_login	= date('Y-m-d H:i:s');
	$iB 			= getBrowser();
	$browser 		= $iB['name'].' '.$iB['version'];

	$tanggal = $_POST['tanggal'];

	$query_preson = "SELECT a.`presence_date` AS tanggal,a.shift_time_in,a.shift_time_out,CONCAT(a.`presence_date`,' ',a.`time_in`) AS absen_in,
	CONCAT(a.`date_out`,' ',a.`time_out`) AS absen_out,
	b.`employees_code` AS no_peg,b.`employees_name` FROM presence a 
	LEFT JOIN employees b ON a.`employees_id` = b.`id` WHERE presence_date = '$tanggal'";
	$result_preson = $connection->query($query_preson);

	$response = array();

	while($row = $result_preson->fetch_assoc()) { 
		$response['data'][] = array('tanggal' => $row['tanggal'],
        'shift_time_in' => $row['shift_time_in'],
        'shift_time_out' => $row['shift_time_out'],
		'absen_in' => $row['absen_in'],
		'absen_out' => $row['absen_out'],
		'employees_code' => $row['no_peg'],
		'employees_name' => $row['employees_name']);
	}

	echo json_encode($response);
	// return json_encode($response);
	

	