<?php session_start();
    require_once'../sw-library/sw-config.php'; 
    require_once'../sw-library/sw-function.php';
    require_once'../sw-mod/out/sw-cookies.php';
    $ip_login  = $_SERVER['REMOTE_ADDR'];
    $time_login = date('Y-m-d H:i:s');
    $iB = getBrowser();
    $browser = $iB['name'].'-'.$iB['version'];
    $allowed_ext = array("png", "jpg", "jpeg");
    //$created_cookies = rand(19999,9999).rand(888888,111111).date('ymdhisss');
    $salt = '$%DEf0&TTd#%dSuTyr47542"_-^@#&*!=QxR094{a911}+';
    $expired_cookie = time()+60*60*24*7;

switch (@$_GET['action']){
case 'login':
  $error = array();
  if (empty($_POST['email'])) { 
        $error[] = 'Username tidak boleh kosong';
    } else { 
      $email = mysqli_real_escape_string($connection,$_POST['email']);
      $created_cookies =  md5($email);
  }

  if (empty($_POST['password'])) { 
        $error[] = 'Password tidak boleh kosong';
    } else {
      $password = hash('sha256',$salt.$_POST['password']);

  }

if (empty($error)){
    $update_user = mysqli_query($connection,"UPDATE employees SET created_login='$time_login',  created_cookies='$created_cookies' WHERE employees_password='$password'");

    $query_login ="SELECT id,employees_code,employees_email,employees_name,created_cookies FROM employees WHERE employees_code='$email' AND employees_password='$password'";
    $result_login       = $connection->query($query_login);
    $row                = $result_login->fetch_assoc();

    $COOKIES_MEMBER         =  epm_encode($row['id']);
    $COOKIES_COOKIES        =  $row['created_cookies'];
      
  $pesan = '<html><body>';
  $pesan .= 'Saat ini ['.$row['employees_name'].'] baru saja login<br>';
  $pesan .= '[Detail Akun] :';
  $pesan .= 'Nama : '.$row['employees_name'].'<br>Email : '.$row['employees_email'].'<br>Ip : '.$ip_login.'<br>Tgl Login : '.$time_login.'<br>Browser : '.$browser.'<br><br><br>';
  $pesan .= 'Hormat Kami,<br>'.$site_name.'<br>Email otomatis, Mohon tidak membalas email ini"';

  $pesan   .= "</body></html>";
  $to       = $row['employees_email'];
  $subject  = ''.$row['employees_name'].' Sedang Online';
  $headers  = "From: " . $site_name." <".$site_email_domain.">\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  if($result_login->num_rows > 0){
      setcookie('COOKIES_MEMBER', $COOKIES_MEMBER, $expired_cookie, '/');
      setcookie('COOKIES_COOKIES', $COOKIES_COOKIES, $expired_cookie, '/');
      echo'success';
  }
  else {
    echo'Username dan password yang Anda masukkan salah!';
    }
  }

  else{       
  	echo'Bidang inputan tidak boleh ada yang kosong!';
  }

break;

/* ------------- REGISTRASI ---------------*/
case 'registrasi':
$error = array();

  if (empty($_POST['employees_code'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_code= anti_injection($_POST['employees_code']);
  }

  if (empty($_POST['employees_name'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_name= anti_injection($_POST['employees_name']);
  }

  if (empty($_POST['employees_email'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_email= anti_injection($_POST['employees_email']);
      $created_cookies = md5($employees_email);
  }


  if (empty($_POST['employees_password'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_password= mysqli_real_escape_string($connection,hash('sha256',$salt.$_POST['employees_password']));
      $password_send = mysqli_real_escape_string($connection,$_POST['employees_password']);
  }


  if (empty($_POST['position_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $position_id = anti_injection($_POST['position_id']);
  }

  if (empty($_POST['shift_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $shift_id = anti_injection($_POST['shift_id']);
  }

  if (empty($_POST['building_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $building_id = anti_injection($_POST['building_id']);
  }

  if (empty($error)) {
    $pesan = '<html><body>';
    $pesan .= 'Pendaftaran Akun di '.$site_name.' berhasil dengan detail akun sebagai berikut:';
    $pesan .= '[Detail Akun] :';
    $pesan .= 'Nama : '.$employees_name.'<br>Email : '.$employees_email.'<br>Password: '.$password_send.'<br>Id : '.$ip.'<br>Browser : '.$browser.'';
    $pesan .= 'Hormat Kami,<br>'.$site_name.'<br>Email otomatis, Mohon tidak membalas email ini"';
    $pesan .= "</body></html>";
    $to     = $employees_email;
    $subject = 'Registrasi Berhasil';
    $headers = "From: ".$site_name."<".$site_email_domain.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if (filter_var($employees_email, FILTER_VALIDATE_EMAIL)) {
  $query="SELECT employees_email from employees where employees_email='$employees_email'";
  $result= $connection->query($query) or die($connection->error.__LINE__);
  if(!$result ->num_rows >0){
    $add ="INSERT INTO employees (employees_code,
              employees_email,
              employees_password,
              employees_name,
              position_id,
              shift_id,
              building_id,
              photo,
              created_login,
              created_cookies) values('$employees_code',
              '$employees_email',
              '$employees_password',
              '$employees_name',
              '$position_id',
              '$shift_id',
              '$building_id',
              '',
              '$date',
              '$created_cookies')";
    if($connection->query($add) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
        mail($to, $subject, $pesan, $headers);
    }}
    else   {
      echo'Sepertinya Email "'.$employees_email.'" sudah terdaftar!';
    }}

    else {
     echo'Email yang anda masukkan salah!';
    }}

    else{           
        echo'Bidang inputan masih ada yang kosong..!';
    }
break;


/* ------------- FORGOT ---------------*/
case 'forgot':
  $pass="1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $panjang_pass='8';$len=strlen($pass); 
  $start=$len-$panjang; $xx=rand('0',$start); 
  $yy=str_shuffle($pass);

$error = array();

  if (empty($_POST['employees_email'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_email= mysqli_real_escape_string($connection, $_POST['employees_email']);
  }


  $passwordbaru = substr($yy, $xx, $panjang_pass);
  $employees_password = mysqli_real_escape_string($connection,hash('sha256',$salt.$passwordbaru));

  if (empty($error)) {
    $pesan = '<html><body>';
    $pesan .= 'Saat ini ['.$employees_email.'] Sedang mengganti Password baru<br>';
    $pesan .= '<b>Password Baru Anda : '.$passwordbaru.'</b><br><br><br>Harap simpan baik-baik akun Anda.<br><br>';
    $pesan .= 'Hormat Kami,<br>'.$site_name.'<br>Email otomatis, Mohon tidak membalas email ini"';
    $pesan .= "</body></html>";
    $to     = $employees_email;
    $subject = 'Ubah Password Baru';
    $headers = "From: " . $site_name." <".$site_email_domain.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if (filter_var($employees_email, FILTER_VALIDATE_EMAIL)) {
  $query="SELECT employees_email from employees where employees_email='$employees_email'";
  $result= $connection->query($query) or die($connection->error.__LINE__);
  if($result ->num_rows >0){
    $row = $result->fetch_assoc();

    $update ="UPDATE employees SET employees_password='$employees_password' WHERE employees_email='$row[employees_email]'";
    if($connection->query($update) === false) { 
        die($connection->error.__LINE__); 
        echo'Penyetelan password baru gagal, silahkan nanti coba kembali!';
    } else{
        echo'success';
        mail($to, $subject, $pesan, $headers);
    }}
    else   {
       echo'Untuk Email "'.$email.'" belum terdaftar, silahkan cek kembali!';
    }}

    else {
     echo'Email yang Anda masukkan salah!';
    }}

    else{           
        echo'Bidang inputan masih ada yang kosong..!';
    }
break;

// ------------- Absen baru-------------*/
case 'absent':
$error = array();
$files        = $_FILES["webcam"]["name"];
$lokasi_file  = $_FILES['webcam']['tmp_name'];  
$ukuran_file  = $_FILES['webcam']['size'];
$extension    = getExtension($files);
$extension    = strtolower($extension);
list($width, $height) = getimagesize($lokasi_file);

if($extension=="jpg" || $extension=="jpeg" ){$src = imagecreatefromjpeg($lokasi_file);}
else if($extension=="png"){$src = imagecreatefrompng($lokasi_file);}
else {$src = imagecreatefromgif($lokasi_file);}
list($width,$height)=getimagesize($lokasi_file);

/* ---------- Set Size Foto ----------------*/
$width_new  = 300;
$height_new = ($height/$width)*$width_new;
$tmp_name   = imagecreatetruecolor($width_new,$height_new);
imagecopyresampled($tmp_name,$src,0,0,0,0,$width_new,$height_new,$width,$height);
/* ---------- Set Size Foto ----------------*/
if (empty($_GET['latitude'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $latitude= mysqli_real_escape_string($connection, $_GET['latitude']);
}
if (empty($_GET['building_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $building_id= mysqli_real_escape_string($connection, $_GET['building_id']);
}

if (empty($error)){
  
  if (($extension="jpg") && ($extension="jpeg") && ($extension="gif")) { 
	
    if($ukuran_file <50000000) {
    // Cek User yang sudah login -----------------------------------------------
    $query_u="SELECT employees.id,employees.employees_code,employees.employees_name,employees.shift_id,shift.shift_id,shift.time_in,shift.time_out,employees.flag_khusus FROM employees,shift WHERE employees.shift_id=shift.shift_id AND employees.id='$row_user[id]'";
    $result_u = $connection->query($query_u);
    if($result_u->num_rows > 0){
		$row_u = $result_u->fetch_assoc();
		$flag_khusus = $row_u['flag_khusus'];
			// --- cek udh absen hari ini ----
			
			$query  ="SELECT * FROM presence WHERE employees_id='$row_u[id]' AND presence_date='$date'";
			$result = $connection->query($query);
			if($result->num_rows == 0){ //  ------- cek absen hari ini ---
				// --- cek jam kerja ---
				$Qshift = "SELECT a.*,b.* FROM employees_shift a LEFT JOIN shift b ON a.shift_id = b.shift_id WHERE a.employees_id = '$row_u[id]' AND a.tanggal = '$date'";
				$rshift = $connection->query($Qshift);
				if($rshift->num_rows > 0){
					$row    = $rshift->fetch_assoc();
					$shift_time_in = $row['time_in'];
					$shift_time_out = $row['time_out'];
				}
				else{
					$query ="select * from shift where shift_id = '$shift_id'";
					$result = $connection->query($query);
					$row    = $result->fetch_assoc();
					$shift_time_in = $row['time_in'];
					$shift_time_out = $row['time_out'];
				}
				
				 /* -------- Upload Foto Masuk -------*/
				$filename =''.$date.'-in-'.time().'-'.$row_user['id'].'.jpeg';
				$directory= "../sw-content/absent/".$filename;
				// --- cek status kerja ---
				$Qkerja = "select * from status_kerja where status = 'aktif'";
				$resultdt = $connection->query($Qkerja);
				$rowdt  = $resultdt->fetch_assoc();
				
				if($flag_khusus==1){
					$ket_kerja = "WFH";	
				}
				else{
					$ket_kerja = $rowdt['ket_kerja'];
				}
				
				// --- cek pegawai koordinat rumah ---*/
				$Employee = "SELECT a.home_coordinate,b.koordinat_kantor,a.position_id,b.radius FROM employees a 
				LEFT JOIN building b ON a.building_id = b.building_id
				WHERE a.id = '$row_u[id]'";
				$result = $connection->query($Employee);
				$row  = $result->fetch_assoc();
				$home_coordinate = $row['home_coordinate'];
				$position_id = $row['position_id'];
				
				// --- koordinat kantor ---
				$Building = "select * from building where building_id = '$building_id'";
				$result2 = $connection->query($Building);
				$row2  = $result2->fetch_assoc();
				$koordinat_kantor = $row2['koordinat_kantor'];
				$range = $row2['radius'];
				
				if($ket_kerja == "WFO"){
					$str = explode(",", $koordinat_kantor);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak ---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters = $kilometers * 1000;
				}
				else{
					$str = explode(",", $home_coordinate);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str3 = explode(",", $koordinat_kantor);
					$lat3 = $str3[0];
					$lon3 = $str3[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak rumah---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters1 = $kilometers * 1000;
					
					// --- rumus menghitung jarak kantor---
					$theta2 = $lon3 - $lon2;
					$miles2 = (sin(deg2rad($lat3)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat3)) * cos(deg2rad($lat2)) * cos(deg2rad($theta2)));
					$miles2 = acos($miles2);
					$miles2 = rad2deg($miles2);
					$miles2 = $miles2 * 60 * 1.1515;
					$feet2 = $miles2 * 5280;
					$yards2 = $feet2 / 3;
					$kilometers2 = round($miles2 * 1.609344,2);
					$meters2 = $kilometers2 * 1000;
					
					if($meters1 <= $range){
						$meters = $meters1;
					}
					else if($meters2 <= $range){
						$meters = $meters2;
					}
					else{
						$meters = $meters1;
					}
				}
				
				if($position_id <> 7){ // ---- selain jab marketing ----
					if($meters > $range){
						if($koordinat_kantor == "" && $ket_kerja == "WFO"){
							echo 'Lokasi anda belum terdaftar';
						}
						else if($home_coordinate == "" && $ket_kerja == "WFH"){
							echo 'Lokasi anda belum terdaftar';
						}
						else{
							echo 'Lokasi absen '.$meters.' meter diluar jangkauan';
						}
					}
					else{
						if($shift_time_in == '23:00:00' || $shift_time_in == '22:00:00'){ // shift 3
							$harilalu = date('Y-m-d', strtotime('-1 days', strtotime($date)));
							$cekdtlalu = "select * from presence where employees_id='$row_u[id]' AND presence_date='$harilalu' AND information = 'shift3'";
							
							$result = $connection->query($cekdtlalu);
							if($result->num_rows > 0){
								$filename =''.$date.'-out-'.time().'-'.$row_user['id'].'.jpeg';
								$directory= "../sw-content/absent/".$filename;
								$rowdt  = $result->fetch_assoc();
								$time_in = $rowdt['time_in'];
								
								// --- versi update ---
								
								 $update ="UPDATE presence SET time_out='$time',picture_out='$filename',date_out='$date',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$harilalu'";
								  if($connection->query($update) === false) { 
									  die($connection->error.__LINE__); 
									  echo'Sepetinya sitem kami sedang error!';
								  } else{
									  //Jam Pulang
									   // --- delete data ---
									  $hapus ="delete from presence WHERE employees_id='$row_u[id]' AND presence_date='$date' AND information = 'shift3_$harilalu'";
									  $connection->query($hapus);
									  
									  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen Pulang pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
									  imagejpeg($tmp_name,$directory,80);
								  }
								  
								 
								  // --- end of versi update ---
							}
							else{
								$cekdt = "select * from presence where presence_date = '$date' and employees_id='$row_u[id]'";
								$result = $connection->query($cekdt);
								if($result->num_rows > 0){
									echo "Anda Sudah Pernah Check In";
								}
								else{
									$nextday = date('Y-m-d', strtotime('+1 days', strtotime($date)));
									$add ="INSERT INTO presence (employees_id,
												  presence_date,
												  date_out,
												  shift_time_in,
												  shift_time_out,
												  time_in,
												  time_out,
												  picture_in,
												  picture_out,
												  present_id,
												  latitude_longtitude_in,
												  latitude_longtitude_out,
												  information) values('$row_u[id]',
												  '$date',
												  '$nextday',
												  '$shift_time_in',
												  '$shift_time_out','$time',
												  '00:00:00',
												  '$filename',
												  '', /*picture out kosong*/
												  '1', /*hadir*/
												  '$latitude',
												  '',
												  'shift3')";     
									if($connection->query($add) === false) { 
										die($connection->error.__LINE__); 
										echo'Sepertinya Sistem Kami sedang error!';
									} else{
										// --- insert next day ---
										$nextday = date('Y-m-d', strtotime('+1 days', strtotime($date)));
										$addNext ="INSERT INTO presence (employees_id,
													  presence_date,
													  shift_time_in,
													  shift_time_out,
													  time_in,
													  time_out,
													  picture_in,
													  picture_out,
													  present_id,
													  latitude_longtitude_in,
													  latitude_longtitude_out,
													  information) values('$row_u[id]',
													  '$nextday',
													  '$shift_time_in',
													  '$shift_time_out',
													  '$time',
													  '00:00:00',
													  '',
													  '', /*picture out kosong*/
													  '1', /*hadir*/
													  '',
													  '',
													  'shift3_$date')";   
										$result = $connection->query($addNext);		
										echo'success/Selamat Anda berhasil Absen pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Semangat bekerja "'.$row_u['employees_name'].'" !';
										imagejpeg($tmp_name,$directory,80);
									}
								}
								
							}
						}
						else{
							$add ="INSERT INTO presence (employees_id,
										  presence_date,
										  date_out,
										  shift_time_in,
										  shift_time_out,
										  time_in,
										  time_out,
										  picture_in,
										  picture_out,
										  present_id,
										  latitude_longtitude_in,
										  latitude_longtitude_out,
										  information) values('$row_u[id]',
										  '$date',
										  '$date',
										  '$shift_time_in',
										  '$shift_time_out',
										  '$time',
										  '00:00:00',
										  '$filename',
										  '', /*picture out kosong*/
										  '1', /*hadir*/
										  '$latitude',
										  '',
										  '')";     
							if($connection->query($add) === false) { 
								die($connection->error.__LINE__); 
								echo'Sepertinya Sistem Kami sedang error!';
							} else{
								// --- cek hari jum'at ---
								if($building_id == 1){
									$hari = date("D",strtotime($date));
									if($hari == "Fri"){
										$update = "update presence set shift_time_in='06:00:00' where employees_id = '$row_u[id]' and presence_date = '$date'";
										$connection->query($update);
									}
								}
								echo'success/Selamat Anda berhasil Absen pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Semangat bekerja "'.$row_u['employees_name'].'" !';
								imagejpeg($tmp_name,$directory,80);
							}
						}
					}
				}
				else{ // --- khusus marketing ---
					/* -------- Upload Foto Masuk -------*/
					$add ="INSERT INTO presence (employees_id,
									  presence_date,
									  date_out,
									  shift_time_in,
									  shift_time_out,
									  time_in,
									  time_out,
									  picture_in,
									  picture_out,
									  present_id,
									  latitude_longtitude_in,
									  latitude_longtitude_out,
									  information) values('$row_u[id]',
									  '$date',
									  '$date',
									  '$shift_time_in',
									  '$shift_time_out',
									  '$time',
									  '00:00:00',
									  '$filename',
									  '', /*picture out kosong*/
									  '1', /*hadir*/
									  '$latitude',
									  '',
									  '')";      
					if($connection->query($add) === false) { 
						die($connection->error.__LINE__); 
						echo'Sepertinya Sistem Kami sedang error!';
					} else{
						echo'success/Selamat Anda berhasil Absen Masuk pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Semangat bekerja "'.$row_u['employees_name'].'" !';
						imagejpeg($tmp_name,$directory,80);
					}
				}
			} // --- end of absen masuk ----
			else{ // --- absen pulang --
				$rabsen = $connection->query($query)->fetch_assoc();
				$shift_time_in = $rabsen['shift_time_in'];
				
				/* -------- Upload Foto Pulang -------*/
                $filename =''.$date.'-out-'.time().'-'.$row_user['id'].'.jpeg';
                $directory= "../sw-content/absent/".$filename;
				
				// --- cek pegawai koordinat rumah ---*/
				$Employee = "SELECT a.home_coordinate,b.koordinat_kantor,a.position_id,b.radius FROM employees a 
				LEFT JOIN building b ON a.building_id = b.building_id
				WHERE a.id = '$row_u[id]'";
				$result = $connection->query($Employee);
				$row  = $result->fetch_assoc();
				$home_coordinate = $row['home_coordinate'];
				$position_id = $row['position_id'];
				
				// --- koordinat kantor ---
				$Building = "select * from building where building_id = '$building_id'";
				$result2 = $connection->query($Building);
				$row2  = $result2->fetch_assoc();
				$koordinat_kantor = $row2['koordinat_kantor'];
				$range = $row2['radius'];
				
				$Qkerja = "select * from status_kerja where status = 'aktif'";
				$resultdt = $connection->query($Qkerja);
				$rowdt  = $resultdt->fetch_assoc();
				
				if($flag_khusus==1){
					$ket_kerja = "WFH";	
				}
				else{
					$ket_kerja = $rowdt['ket_kerja'];
				}
				
				if($ket_kerja == "WFO"){
					$str = explode(",", $koordinat_kantor);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak ---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters = $kilometers * 1000;
				}
				else{
					$str = explode(",", $home_coordinate);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str3 = explode(",", $koordinat_kantor);
					$lat3 = $str3[0];
					$lon3 = $str3[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak rumah---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters1 = $kilometers * 1000;
					
					// --- rumus menghitung jarak kantor---
					$theta2 = $lon3 - $lon2;
					$miles2 = (sin(deg2rad($lat3)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat3)) * cos(deg2rad($lat2)) * cos(deg2rad($theta2)));
					$miles2 = acos($miles2);
					$miles2 = rad2deg($miles2);
					$miles2 = $miles2 * 60 * 1.1515;
					$feet2 = $miles2 * 5280;
					$yards2 = $feet2 / 3;
					$kilometers2 = round($miles2 * 1.609344,2);
					$meters2 = $kilometers2 * 1000;
					
					if($meters1 <= $range){
						$meters = $meters1;
					}
					else if($meters2 <= $range){
						$meters = $meters2;
					}
					else{
						$meters = $meters1;
					}
				}
				
				if($position_id <> 7){ // ---- selain jab marketing ----
					if($meters > $range){
						if($koordinat_kantor == "" && $ket_kerja == "WFO"){
							echo 'Lokasi anda belum terdaftar';
						}
						else if($home_coordinate == "" && $ket_kerja == "WFH"){
							echo 'Lokasi anda belum terdaftar';
						}
						else{
							echo 'Lokasi absen '.$meters.' meter diluar jangkauan';
						}
					}
					else{
						if($shift_time_in == "23:00:00" || $shift_time_in == "22:00:00"){
							$harilalu = date('Y-m-d', strtotime('-1 days', strtotime($date)));
							// --- versi update ---
							 $update ="UPDATE presence SET time_out='$time',picture_out='$filename',date_out='$date',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$harilalu'";
							  if($connection->query($update) === false) { 
								  die($connection->error.__LINE__); 
								  echo'Sepetinya sitem kami sedang error!';
							  } else{
								  //Jam Pulang
								   // --- delete data ---
								  $hapus ="delete from presence WHERE employees_id='$row_u[id]' AND presence_date='$date' AND information = 'shift3_$harilalu'";
								  $connection->query($hapus);
								  
								  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
								  imagejpeg($tmp_name,$directory,80);
							  }
							  
							 
							  // --- end of versi update ---
						}
						else{
							/* -------- Upload Foto Pulang jabatan marketing-------*/
							  $update ="UPDATE presence SET time_out='$time',picture_out='$filename',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$date'";
							  if($connection->query($update) === false) { 
								  die($connection->error.__LINE__); 
								  echo'Sepetinya sitem kami sedang error!';
							  } else{
								  //Jam Pulang
								  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
								  imagejpeg($tmp_name,$directory,80);
							  }
						}
					}
				}
				else{
					/* -------- Upload Foto Pulang jabatan marketing-------*/
					  $update ="UPDATE presence SET time_out='$time',picture_out='$filename',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$date'";
					  if($connection->query($update) === false) { 
						  die($connection->error.__LINE__); 
						  echo'Sepetinya sitem kami sedang error!';
					  } else{
						  //Jam Pulang
						  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
						  imagejpeg($tmp_name,$directory,80);
					  }
				}
				
			}// --- end of absen pulang ---
		}
      else{
        // Jika user tidak ditemukan
        echo'User tidak ditemukan';die($connection->error.__LINE__); 
      }}
      else{
        echo 'Foto terlalu besar Maksimal Size 5MB.!';
      }
    }
    else{
      echo'Gambar/Foto yang di unggah tidak sesuai dengan format, Berkas harus berformat JPG,JPEG,GIF..!';
    }
  }
    else{
      echo 'Silahkan Izinkan Lokasi Anda saat ini!';
}

break;
// --- end of absen baru ---

// ------------- Absen -------------*/
case 'absentLama':
$error = array();
$files        = $_FILES["webcam"]["name"];
$lokasi_file  = $_FILES['webcam']['tmp_name'];  
$ukuran_file  = $_FILES['webcam']['size'];
$extension    = getExtension($files);
$extension    = strtolower($extension);
list($width, $height) = getimagesize($lokasi_file);

if($extension=="jpg" || $extension=="jpeg" ){$src = imagecreatefromjpeg($lokasi_file);}
else if($extension=="png"){$src = imagecreatefrompng($lokasi_file);}
else {$src = imagecreatefromgif($lokasi_file);}
list($width,$height)=getimagesize($lokasi_file);

/* ---------- Set Size Foto ----------------*/
$width_new  = 300;
$height_new = ($height/$width)*$width_new;
$tmp_name   = imagecreatetruecolor($width_new,$height_new);
imagecopyresampled($tmp_name,$src,0,0,0,0,$width_new,$height_new,$width,$height);
/* ---------- Set Size Foto ----------------*/
if (empty($_GET['latitude'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $latitude= mysqli_real_escape_string($connection, $_GET['latitude']);
}
if (empty($_GET['building_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $building_id= mysqli_real_escape_string($connection, $_GET['building_id']);
}


if (empty($error)){
  
  if (($extension="jpg") && ($extension="jpeg") && ($extension="gif")) { 
  
	// --- cek pegawai shift ---
	/*
	$query ="select * from shift where shift_id = '$shift_id'";
	$result = $connection->query($query);
	$row    = $result->fetch_assoc();
	$shift_time_in = $row['time_in'];
	$shift_time_out = $row['time_out'];
	*/
	
    if($ukuran_file <50000000) {
    // Cek User yang sudah login -----------------------------------------------
    $query_u="SELECT employees.id,employees.employees_code,employees.employees_name,employees.shift_id,shift.shift_id,shift.time_in,shift.time_out,employees.flag_khusus FROM employees,shift WHERE employees.shift_id=shift.shift_id AND employees.id='$row_user[id]'";
    $result_u = $connection->query($query_u);
    if($result_u->num_rows > 0){
    $row_u = $result_u->fetch_assoc();

        // Cek data Absen Berdasarkan tanggal sekarang
        $query  ="SELECT employees_id,time_in,time_out FROM presence WHERE employees_id='$row_u[id]' AND presence_date='$date' and shift_time_in NOT IN ('23:00:00','22:00:00')";
     
		$result = $connection->query($query);
        if($result->num_rows > 0){
          $row = $result->fetch_assoc();
          // Update Absensi Pulang
              if($row['time_out'] <> '(NULL)'){
                //Update Jam Pulang
                /* -------- Upload Foto Pulang -------*/
                $filename =''.$date.'-out-'.time().'-'.$row_user['id'].'.jpeg';
                $directory= "../sw-content/absent/".$filename;
				
				// --- cek status kerja ---
				$Qkerja = "select * from status_kerja where status = 'aktif'";
				$resultdt = $connection->query($Qkerja);
				$rowdt  = $resultdt->fetch_assoc();
				
				if($row_u['flag_khusus']){
					$ket_kerja = "WFH";	
				}
				else{
					$ket_kerja = $rowdt['ket_kerja'];
				}
				// --- cek pegawai ---*/
				$Employee = "SELECT a.home_coordinate,b.koordinat_kantor,a.position_id,b.radius FROM employees a 
				LEFT JOIN building b ON a.building_id = b.building_id
				WHERE a.id = '$row_u[id]'";
				$result = $connection->query($Employee);
				$row  = $result->fetch_assoc();
				
				$home_coordinate = $row['home_coordinate'];
				$position_id = $row['position_id'];
				//$koordinat_kantor = $row['koordinat_kantor'];
				//$range = $row['radius'];
				
				// --- koordinat kantor ---
				$Building = "select * from building where building_id = '$building_id'";
				$result2 = $connection->query($Building);
				$row2  = $result2->fetch_assoc();
				$koordinat_kantor = $row2['koordinat_kantor'];
				$range = $row2['radius'];
				
				if($ket_kerja == "WFO"){
					$str = explode(",", $koordinat_kantor);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak ---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters = $kilometers * 1000;
				}
				else{
					$str = explode(",", $home_coordinate);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str3 = explode(",", $koordinat_kantor);
					$lat3 = $str3[0];
					$lon3 = $str3[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak rumah---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters1 = $kilometers * 1000;
					
					// --- rumus menghitung jarak kantor---
					$theta2 = $lon3 - $lon2;
					$miles2 = (sin(deg2rad($lat3)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat3)) * cos(deg2rad($lat2)) * cos(deg2rad($theta2)));
					$miles2 = acos($miles2);
					$miles2 = rad2deg($miles2);
					$miles2 = $miles2 * 60 * 1.1515;
					$feet2 = $miles2 * 5280;
					$yards2 = $feet2 / 3;
					$kilometers2 = round($miles2 * 1.609344,2);
					$meters2 = $kilometers2 * 1000;
					
					if($meters1 <= $range){
						$meters = $meters1;
					}
					else if($meters2 <= $range){
						$meters = $meters2;
					}
					else{
						$meters = $meters1;
					}
				}
			
				if($position_id <> 7){
					if($meters > $range){
						if($koordinat_kantor == "" && $ket_kerja == "WFO"){
							echo 'Lokasi anda belum terdaftar';
						}
						else if($home_coordinate == "" && $ket_kerja == "WFH"){
							echo 'Lokasi anda belum terdaftar';
						}
						else{
							echo 'Lokasi absen '.$meters.' meter diluar jangkauan';
						}
					}
					else{
						/* -------- Upload Foto Pulang -------*/
						  $update ="UPDATE presence SET time_out='$time',picture_out='$filename',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$date'";
						  if($connection->query($update) === false) { 
							  die($connection->error.__LINE__); 
							  echo'Sepetinya sitem kami sedang error!';
						  } else{
							  //Jam Pulang
							  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen Pulang pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
							  imagejpeg($tmp_name,$directory,80);
						  }
					  
					}
				}
				else{
					/* -------- Upload Foto Pulang jabatan marketing-------*/
					  $update ="UPDATE presence SET time_out='$time',picture_out='$filename',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$date'";
					  if($connection->query($update) === false) { 
						  die($connection->error.__LINE__); 
						  echo'Sepetinya sitem kami sedang error!';
					  } else{
						  //Jam Pulang
						  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen Pulang pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
						  imagejpeg($tmp_name,$directory,80);
					  }
				}
              }
              else{
                echo'Sebelumnya "'.$row_user['employees_name'].'" sudah pernah Absen Pulang pada Tanggal '.tanggal_ind($date).' dan Jam '.$row['time_out'].'.!';
              }
        // Else Absen Masuk
        }else{
			if (empty($_GET['shift_id'])) {
			  echo 'Shift tidak boleh kosong';
			  break;
			} else {
			  $shift_id= mysqli_real_escape_string($connection, $_GET['shift_id']);
			}

            /* -------- Upload Foto Masuk -------*/
            $filename =''.$date.'-in-'.time().'-'.$row_user['id'].'.jpeg';
            $directory= "../sw-content/absent/".$filename;
			// --- cek status kerja ---
			$Qkerja = "select * from status_kerja where status = 'aktif'";
			$resultdt = $connection->query($Qkerja);
			$rowdt  = $resultdt->fetch_assoc();
			
			if($row_u['flag_khusus']){
				$ket_kerja = "WFH";	
			}
			else{
				$ket_kerja = $rowdt['ket_kerja'];
			}
			
			// --- cek pegawai ---*/
			$Employee = "SELECT a.home_coordinate,b.koordinat_kantor,a.position_id,b.radius FROM employees a 
			LEFT JOIN building b ON a.building_id = b.building_id
			WHERE a.id = '$row_u[id]'";
			$result = $connection->query($Employee);
			$row  = $result->fetch_assoc();
			$home_coordinate = $row['home_coordinate'];
			$position_id = $row['position_id'];
			//$koordinat_kantor = $row['koordinat_kantor'];
			//$range = $row['radius'];
			
			// --- koordinat kantor ---
			$Building = "select * from building where building_id = '$building_id'";
			$result2 = $connection->query($Building);
			$row2  = $result2->fetch_assoc();
			$koordinat_kantor = $row2['koordinat_kantor'];
			$range = $row2['radius'];
			
			// --- cek pegawai shift ---
			$query ="select * from shift where shift_id = '$shift_id'";
			$result = $connection->query($query);
			$row    = $result->fetch_assoc();
			$shift_time_in = $row['time_in'];
			$shift_time_out = $row['time_out'];
			
			
			/*
			// --- cek pegawai shift ---
			$Qcek = "SELECT a.employees_id AS id,a.shift_id,b.time_in,b.time_out  FROM employees_shift a 
			LEFT JOIN shift b ON a.shift_id = b.shift_id
			WHERE a.tanggal = '$date' AND a.employees_id = '$row_u[id]'";
			$result = $connection->query($Qcek);
			$dt = $result->num_rows;
			  
			if($dt > 0){
				$result = $connection->query($Qcek);  
				$row    = $result->fetch_assoc();
				$shift_time_in = $row['time_in'];
				$shift_time_out = $row['time_out'];
			}
			else{
				$query ="SELECT employees.id,shift.shift_id,shift.time_in,shift.time_out FROM employees,shift WHERE employees.shift_id=shift.shift_id AND employees.id='$row_u[id]'";
				$result = $connection->query($query);
				$row    = $result->fetch_assoc();
				$shift_time_in = $row['time_in'];
				$shift_time_out = $row['time_out'];
			}
			// --- end cek pegawai shift ---
			*/
			
			if($ket_kerja == "WFO"){
				$str = explode(",", $koordinat_kantor);
				$lat1 = $str[0];
				$lon1 = $str[1];
				
				$str2 = explode(",", $latitude);
				$lat2 = $str2[0];
				$lon2 = $str2[1];
				
				// --- rumus menghitung jarak ---
				$theta = $lon1 - $lon2;
				$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
				$miles = acos($miles);
				$miles = rad2deg($miles);
				$miles = $miles * 60 * 1.1515;
				$feet = $miles * 5280;
				$yards = $feet / 3;
				$kilometers = round($miles * 1.609344,2);
				$meters = $kilometers * 1000;
				
				/*
				if($meters > $range){
					// --- cek lokasi ke 2 ---
					$Employee = "SELECT a.position_id,b.building_id,c.koordinat_kantor,c.radius FROM employees a
					LEFT JOIN office_employees b ON a.employees_code = b.employees_code 
					LEFT JOIN building c ON c.building_id = b.building_id
					WHERE a.id = '$row_u[id]'";
					$result = $connection->query($Employee);
					$row  = $result->fetch_assoc();
					
					$koordinat_kantor = $row['koordinat_kantor'];
					$position_id = $row['position_id'];
					$range = $row['radius'];
					
					$str = explode(",", $koordinat_kantor);
					$lat1 = $str[0];
					$lon1 = $str[1];
					
					$str2 = explode(",", $latitude);
					$lat2 = $str2[0];
					$lon2 = $str2[1];
					
					// --- rumus menghitung jarak ---
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = round($miles * 1.609344,2);
					$meters = $kilometers * 1000;
				}
				*/
			}
			else{
				$str = explode(",", $home_coordinate);
				$lat1 = $str[0];
				$lon1 = $str[1];
				
				$str3 = explode(",", $koordinat_kantor);
				$lat3 = $str3[0];
				$lon3 = $str3[1];
				
				$str2 = explode(",", $latitude);
				$lat2 = $str2[0];
				$lon2 = $str2[1];
				
				// --- rumus menghitung jarak rumah---
				$theta = $lon1 - $lon2;
				$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
				$miles = acos($miles);
				$miles = rad2deg($miles);
				$miles = $miles * 60 * 1.1515;
				$feet = $miles * 5280;
				$yards = $feet / 3;
				$kilometers = round($miles * 1.609344,2);
				$meters1 = $kilometers * 1000;
				
				// --- rumus menghitung jarak kantor---
				$theta2 = $lon3 - $lon2;
				$miles2 = (sin(deg2rad($lat3)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat3)) * cos(deg2rad($lat2)) * cos(deg2rad($theta2)));
				$miles2 = acos($miles2);
				$miles2 = rad2deg($miles2);
				$miles2 = $miles2 * 60 * 1.1515;
				$feet2 = $miles2 * 5280;
				$yards2 = $feet2 / 3;
				$kilometers2 = round($miles2 * 1.609344,2);
				$meters2 = $kilometers2 * 1000;
				
				if($meters1 <= $range){
					$meters = $meters1;
				}
				else if($meters2 <= $range){
					$meters = $meters2;
				}
				else{
					$meters = $meters1;
				}
			}
			
			
			
			if($position_id <> 7){
				if($meters > $range){
					if($koordinat_kantor == "" && $ket_kerja == "WFO"){
						echo 'Lokasi anda belum terdaftar';
					}
					else if($home_coordinate == "" && $ket_kerja == "WFH"){
						echo 'Lokasi anda belum terdaftar';
					}
					else{
						echo 'Lokasi absen '.$meters.' meter diluar jangkauan';
					}
				}
				else{
					/* -------- Upload Foto Masuk -------*/
					if($shift_time_in == '23:00:00' || $shift_time_in == '22:00:00'){
						$harilalu = date('Y-m-d', strtotime('-1 days', strtotime($date)));
						$cekdtlalu = "select * from presence where employees_id='$row_u[id]' AND presence_date='$harilalu' AND information = 'shift3'";
						
						$result = $connection->query($cekdtlalu);
						if($result->num_rows > 0){
							
							$filename =''.$date.'-out-'.time().'-'.$row_user['id'].'.jpeg';
							$directory= "../sw-content/absent/".$filename;
							$rowdt  = $result->fetch_assoc();
							$time_in = $rowdt['time_in'];
							
							// --- versi update ---
							
							 $update ="UPDATE presence SET time_out='$time',picture_out='$filename',date_out='$date',latitude_longtitude_out='$latitude' WHERE employees_id='$row_u[id]' AND presence_date='$harilalu'";
							  if($connection->query($update) === false) { 
								  die($connection->error.__LINE__); 
								  echo'Sepetinya sitem kami sedang error!';
							  } else{
								  //Jam Pulang
								   // --- delete data ---
								  $hapus ="delete from presence WHERE employees_id='$row_u[id]' AND presence_date='$date' AND information = 'shift3_$harilalu'";
								  $connection->query($hapus);
								  
								  echo'success/Selamat "'.$row_user['employees_name'].'" berhasil Absen Pulang pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Hati-hati dijalan saat pulang "'.$row_u['employees_name'].'"!';
								  imagejpeg($tmp_name,$directory,80);
							  }
							  
							 
							  // --- end of versi update ---
						}
						else{
							$cekdt = "select * from presence where presence_date = '$date' and employees_id='$row_u[id]'";
							$result = $connection->query($cekdt);
							if($result->num_rows > 0){
								echo "Anda Sudah Pernah Check In";
							}
							else{
								$nextday = date('Y-m-d', strtotime('+1 days', strtotime($date)));
								$add ="INSERT INTO presence (employees_id,
											  presence_date,
											  date_out,
											  shift_time_in,
											  shift_time_out,
											  time_in,
											  time_out,
											  picture_in,
											  picture_out,
											  present_id,
											  latitude_longtitude_in,
											  latitude_longtitude_out,
											  information) values('$row_u[id]',
											  '$date',
											  '$nextday',
											  '$shift_time_in',
											  '$shift_time_out',
											  '$time',
											  '00:00:00',
											  '$filename',
											  '', /*picture out kosong*/
											  '1', /*hadir*/
											  '$latitude',
											  '',
											  'shift3')";     
								if($connection->query($add) === false) { 
									die($connection->error.__LINE__); 
									echo'Sepertinya Sistem Kami sedang error!';
								} else{
									
									// --- insert next day ---
									$nextday = date('Y-m-d', strtotime('+1 days', strtotime($date)));
									$addNext ="INSERT INTO presence (employees_id,
												  presence_date,
												  shift_time_in,
												  shift_time_out,
												  time_in,
												  time_out,
												  picture_in,
												  picture_out,
												  present_id,
												  latitude_longtitude_in,
												  latitude_longtitude_out,
												  information) values('$row_u[id]',
												  '$nextday',
												  '$shift_time_in',
												  '$shift_time_out',
												  '$time',
												  '00:00:00',
												  '',
												  '', /*picture out kosong*/
												  '1', /*hadir*/
												  '',
												  '',
												  'shift3_$date')";   
									$result = $connection->query($addNext);		
									
									echo'success/Selamat Anda berhasil Absen Masuk pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Semangat bekerja "'.$row_u['employees_name'].'" !';
									imagejpeg($tmp_name,$directory,80);
								}
							}
							
								
						}
					}
					else{
					// --- cek data shift 3 ---
					$cekdtlalu = "select * from presence where employees_id='$row_u[id]' AND presence_date='$date'";
					$result = $connection->query($cekdtlalu);
					if($result->num_rows > 0){
						echo "Silahkan Check Out Terlebih Dahulu dari Shift 3";
						break;
					}
					else{
						$add ="INSERT INTO presence (employees_id,
										  presence_date,
										  date_out,
										  shift_time_in,
										  shift_time_out,
										  time_in,
										  time_out,
										  picture_in,
										  picture_out,
										  present_id,
										  latitude_longtitude_in,
										  latitude_longtitude_out,
										  information) values('$row_u[id]',
										  '$date',
										  '$date',
										  '$shift_time_in',
										  '$shift_time_out',
										  '$time',
										  '00:00:00',
										  '$filename',
										  '', /*picture out kosong*/
										  '1', /*hadir*/
										  '$latitude',
										  '',
										  '')";     
							if($connection->query($add) === false) { 
								die($connection->error.__LINE__); 
								echo'Sepertinya Sistem Kami sedang error!';
							} else{
								// --- cek hari jum'at ---
								if($building_id == 1){
									$hari = date("D",strtotime($date));
									if($hari == "Fri"){
										$update = "update presence set shift_time_in='06:00:00' where employees_id = '$row_u[id]' and presence_date = '$date'";
										$connection->query($update);
									}
								}
								echo'success/Selamat Anda berhasil Absen Masuk pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Semangat bekerja "'.$row_u['employees_name'].'" !';
								imagejpeg($tmp_name,$directory,80);
							}
						}
					}
				}
			}
			else{
				/* -------- Upload Foto Masuk -------*/
				$add ="INSERT INTO presence (employees_id,
								  presence_date,
								  date_out,
								  shift_time_in,
								  shift_time_out,
								  time_in,
								  time_out,
								  picture_in,
								  picture_out,
								  present_id,
								  latitude_longtitude_in,
								  latitude_longtitude_out,
								  information) values('$row_u[id]',
								  '$date',
								  '$date',
								  '$shift_time_in',
							      '$shift_time_out',
								  '$time',
								  '00:00:00',
								  '$filename',
								  '', /*picture out kosong*/
								  '1', /*hadir*/
								  '$latitude',
								  '',
								  '')";      
				if($connection->query($add) === false) { 
					die($connection->error.__LINE__); 
					echo'Sepertinya Sistem Kami sedang error!';
				} else{
					echo'success/Selamat Anda berhasil Absen Masuk pada Tanggal '.tanggal_ind($date).' dan Jam : '.$time.', Semangat bekerja "'.$row_u['employees_name'].'" !';
					imagejpeg($tmp_name,$directory,80);
				}
			}
          }
		
      }
      else{
        // Jika user tidak ditemukan
        echo'User tidak ditemukan';die($connection->error.__LINE__); 
      }}
      else{
        echo 'Foto terlalu besar Maksimal Size 5MB.!';
      }
    }
    else{
      echo'Gambar/Foto yang di unggah tidak sesuai dengan format, Berkas harus berformat JPG,JPEG,GIF..!';
    }
  }
    else{
      echo 'Silahkan Izinkan Lokasi Anda saat ini!';
}
 


// ----------- UPDATE PROFILE -------------------//
break;
case 'profile':
  $error = array();

  if (empty($_POST['employees_name'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_name= mysqli_real_escape_string($connection, $_POST['employees_name']);
  }
  /*
  if (empty($_POST['position_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $position_id = mysqli_real_escape_string($connection, $_POST['position_id']);
  }
  */

  if (empty($_POST['shift_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $shift_id = mysqli_real_escape_string($connection, $_POST['shift_id']);
  }
  
  if (empty($_POST['address'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $address = mysqli_real_escape_string($connection, $_POST['address']);
  }
  
  if (empty($_POST['phone'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $phone = mysqli_real_escape_string($connection, $_POST['phone']);
  }
  
  /*
  if (empty($_POST['building_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $building_id = mysqli_real_escape_string($connection, $_POST['building_id']);
  }
 */

  if (empty($error)) { 
    $update="UPDATE employees SET employees_name='$employees_name',
            shift_id='$shift_id',address='$address',phone='$phone' WHERE id='$row_user[id]'"; 
    if($connection->query($update) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
    }}
    else{           
        echo'Bidang inputan tidak boleh ada yang kosong..!';
  }
break;


// ----------- UPDATE PASSWORD -------------------//
case 'update-password':
 $error = array();
  if (empty($_POST['employees_email'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_email= mysqli_real_escape_string($connection,$_POST['employees_email']);
  }

  if (empty($_POST['employees_password'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_password= mysqli_real_escape_string($connection,$_POST['employees_password']);
      $password_baru =mysqli_real_escape_string($connection,hash('sha256',$salt.$employees_password));
  }

  if (empty($error)) { 
    $pesan = '<html><body>';
    $pesan .= 'Saat ini ['.$employees_email.'] Sedang mengganti Password baru<br>';
    $pesan .= '<b>Password Baru Anda : '.$employees_password.'</b><br><br><br>Harap simpan baik-baik akun Anda.<br><br>';
    $pesan .= 'Hormat Kami,<br>'.$site_name.'<br>Email otomatis, Mohon tidak membalas email ini"';
    $pesan .= "</body></html>";
    $to     = $employees_email;
    $subject = 'Ubah Katasandi Baru';
    $headers = "From: " . $site_name." <".$site_email_domain.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $update="UPDATE employees SET employees_password='$password_baru' WHERE id='$id'"; 
    if($connection->query($update) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
        mail($to, $subject, $pesan, $headers);
    }}
    else{           
        echo'Bidang inputan tidak boleh ada yang kosong..!';
    }
break;

/* -------- UPDATE PHOTO ----------------*/
case 'update-photo':
  $file_name   = $_FILES['file'] ['name'];
  $size        = $_FILES['file'] ['size'];
  $error       = $_FILES['file'] ['error'];
  $tmpName     = $_FILES['file']['tmp_name'];
  $filepath      = '../sw-content/karyawan/';
  $valid       = array('jpg','png','gif','jpeg'); 
  if(strlen($file_name)){   
       // Perintah untuk mengecek format gambar
       list($txt,$ext) = explode(".", $file_name);
       $file_ext = substr($file_name, strripos($file_name, '.'));

       if(in_array($ext,$valid)){   
         if($size<500000){   
           // Perintah pengganti nama files
           //$photo_new   = strip_tags(md5($file_name));
           $photo_new   =''.$row_user['employees_code'].'-'.strip_tags(md5($file_name)).'-'.seo_title($time).'-'.$file_ext.'';
           $pathFile    = $filepath.$photo_new;

            $query = "SELECT photo FROM employees WHERE id='$row_user[id]'"; 
                $result = $connection->query($query);
                $rows= $result->fetch_assoc();
                $photo = $rows['photo'];
                if(file_exists("../sw-content/$photo")){
                  unlink( "../sw-content/karyawan/$photo");
                 }
           $update ="UPDATE employees SET photo='$photo_new' WHERE id=$row_user[id]";
            if($connection->query($update) === false) { 
               echo'Pengaturan tidak dapat disimpan, coba ulangi beberapa saat lagi.!';
               die($connection->error.__LINE__); 
            } else   {
              echo'success';
               move_uploaded_file($tmpName, $pathFile);
            }
          }
         else{ // Jika Gambar melebihi size 
              echo'File terlalu besar maksimal files 5MB.!';  
           }         
       }
       else{
          echo 'File yang di unggah tidak sesuai dengan format, File harus jpg, jpeg, gif, png.!';
        }
     }   
break;


/* -------  LOAD DATA HISTORY ----------*/
case 'history':
if(isset($_POST['from']) OR isset($_POST['to'])){
      $from = date('Y-m-d', strtotime($_POST['from']));
      $to   = date('Y-m-d', strtotime($_POST['to']));

      $filter ="presence_date BETWEEN '$from' AND '$to'";
  } 
  else{
      $filter ="MONTH(presence_date) ='$month'";
}

echo'<table class="table rounded" id="swdatatable">
    <thead>
        <tr>
            <th scope="col" class="align-middle text-center" width="10">No</th>
            <th scope="col" class="align-middle">Tanggal</th>
            <th scope="col" class="align-middle">Absen Masuk</th>
            <th scope="col" class="align-middle">Absen Pulang</th>
            <th scope="col" class="align-middle hidden-sm">Status</th>
            <th scope="col" class="align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody>';
    $no=0;
    $query_shift ="SELECT time_in,time_out FROM shift WHERE shift_id='$row_user[shift_id]'";
    $result_shift = $connection->query($query_shift);
    $row_shift = $result_shift->fetch_assoc();
    $shift_time_in  = $row_shift['time_in'];
    $shift_time_out = $row_shift['time_out'];
    $newtimestamp   = strtotime(''.$shift_time_in.' + 05 minute');
    $newtimestamp   = date('H:i:s', $newtimestamp);
	
	/*
    $query_absen ="SELECT presence_id,presence_date,picture_in,time_in,picture_out,time_out,present_id, latitude_longtitude_in, latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),'$shift_time_in') AS selisih,if (time_in>'$shift_time_in','Telat',if(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS status, if (time_out<'$shift_time_out','Pulang Cepat','Tepat Waktu') AS status_pulang FROM presence WHERE employees_id='$row_user[id]' AND $filter ORDER BY presence_id DESC";
	*/
	
    $query_absen ="SELECT presence_id,presence_date,picture_in,time_in,picture_out,time_out,present_id, latitude_longtitude_in, latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,if (time_in>shift_time_in,'Telat',if(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS status, if (time_out<shift_time_out,'Pulang Cepat','Tepat Waktu') AS status_pulang FROM presence WHERE employees_id='$row_user[id]' AND $filter ORDER BY presence_id DESC";
	
    $result_absen = $connection->query($query_absen);
    if($result_absen->num_rows > 0){
        while ($row_absen = $result_absen->fetch_assoc()) {

          $query_status ="SELECT present_name FROM  present_status WHERE present_id='$row_absen[present_id]'";
          $result_status = $connection->query($query_status);
          $row_aa= $result_status->fetch_assoc();
            $no++;
            if($row_absen['information']==''){
              $information = '';
            }else{
              $information = '<br>'.$row_absen['information'].'';
            }

      if($row_absen['status']=='Telat'){
          $status=' <span class="badge badge-danger">'.$row_absen['status'].'</span>';
        }
        elseif ($row_absen['status']='Tepat Waktu') {
          $status='<span class="badge badge-success">'.$row_absen['status'].'</span>';
        }
        else{
          $status='<span class="badge badge-danger">'.$row_absen['status'].'</span>';
        }

        if($row_absen['status_pulang']=='Pulang Cepat'){
          $status_pulang='<span class="badge badge-danger">'.$row_absen['status_pulang'].'</span>';
        }
        else{
          $status_pulang='';
        }

        echo'
        <tr>
            <th class="text-center">'.$no.'</th>
            <th scope="row">'.tgl_ind($row_absen['presence_date']).'</th>
            
            <td><a class="image-link" href="./sw-content/absent/'.$row_absen['picture_in'].'">
            <span class="badge badge-success">'.$row_absen['time_in'].'</span></a>'.$status.'</td>

            <td><a class="image-link" href="./sw-content/absent/'.$row_absen['picture_out'].'">
            <span class="badge badge-success">'.$row_absen['time_out'].'</span></a> '.$status_pulang.'</td>

            <td class="hidden-sm">'.$row_aa['present_name'].''.$information.'</td>
            <td class="text-center">
              <button type="button" class="btn btn-success btn-sm modal-update" data-id="'.$row_absen['presence_id'].'" data-masuk="'.$row_absen['time_in'].'" data-pulang="'.$row_absen['time_out'].'" data-date="'.tgl_indo($row_absen['presence_date']).'" data-information="'.$row_absen['information'].'" data-status="'.$row_absen['present_id'].'" data-toggle="modal" data-target="#modal-show"><i class="fas fa-pencil-alt"></i></button>
            </td>
        </tr>';
    }}
    echo'
    </tbody>
</table>
<hr>';
      $query_hadir="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND present_id='1' ORDER BY presence_id DESC";
      $hadir= $connection->query($query_hadir);

      $query_sakit="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND present_id='2' ORDER BY presence_id";
      $sakit = $connection->query($query_sakit);

      $query_izin="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND present_id='3' ORDER BY presence_id";
      $izin = $connection->query($query_izin);

      $query_telat ="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND time_in>shift_time_in";
      $telat = $connection->query($query_telat);
echo'
<div class="container">
<div class="row">
  <div class="col-md-3">
    <p>Hadir : <span class="badge badge-success">'.$hadir->num_rows.'</span></p>
  </div>

  <div class="col-md-3">
    <p>Terlambat : <span class="label badge badge-danger">'.$telat->num_rows.'</span></p>
  </div>
  

  <div class="col-md-3">
    <p>Sakit : <span class="badge badge-warning">'.$sakit->num_rows.'</span></p>
  </div>

  <div class="col-md-3">
    <p>Izin : <span class="badge badge-info">'.$izin->num_rows.'</span></p>
  </div>
</div>
</div>';?>

<script>
  $('#swdatatable').dataTable({
    "iDisplayLength":35,
    "aLengthMenu": [[35, 40, 50, -1], [35, 40, 50, "All"]]
  });
  $('.image-link').magnificPopup({type:'image'});
</script>
<?php


// ----------- UPDATE HISTORY -------------------//
break;
case 'update-history':
  $error = array();
  if (empty($_POST['presence_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $presence_id = mysqli_real_escape_string($connection, $_POST['presence_id']);
  }

  if (empty($_POST['present_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $present_id= mysqli_real_escape_string($connection, $_POST['present_id']);
  }

  $information = mysqli_real_escape_string($connection, $_POST['information']);
 
  if (empty($error)) { 
    $update="UPDATE presence SET present_id='$present_id',
                    information='$information' WHERE presence_id='$presence_id' AND employees_id='$row_user[id]'"; 
    if($connection->query($update) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
    }}
    else{           
        echo'Bidang inputan tidak boleh ada yang kosong..!';
  }

// ----------- UPDATE HISTORY -------------------//
break;
case 'cuty':
if(isset($_POST['from']) OR isset($_POST['to'])){
      $from = date('Y-m-d', strtotime($_POST['from']));
      $to   = date('Y-m-d', strtotime($_POST['to']));

      $filter ="cuty_start BETWEEN '$from' AND '$to'";
  } 
  else{
      $filter ="MONTH(cuty_start) ='$month'";
}

$query_cuty ="SELECT employees.employees_name,cuty.* FROM employees,cuty WHERE employees.id=cuty.employees_id  AND $filter  AND cuty.employees_id='$row_user[id]' ORDER BY cuty.cuty_id DESC";
    $result_cuty = $connection->query($query_cuty);
    if($result_cuty->num_rows > 0){
      while ($row_cuty = $result_cuty->fetch_assoc()) {
        if($row_cuty['cuty_status']=='1'){
          $status = '<span class="badge badge-success">Disetujui</span>';
        }elseif($row_cuty['cuty_status']=='2'){
          $status = '<span class="badge badge-danger">Tidak disetujui</span>';
        }else{
          $status = '<span class="badge badge-secondary">Blm.Approve</span>';
        }
      echo'
      <div class="item">
          <div class="detail">
              <div>
                  <strong>'.$row_cuty['employees_name'].' '.$status.'</strong>
                  <p><ion-icon name="calendar-outline"></ion-icon> '.tanggal_ind($row_cuty['cuty_start']).' s.d. '.tanggal_ind($row_cuty['cuty_end']).'<br><ion-icon name="calendar-outline"></ion-icon> Jumlah Cuti: '.$row_cuty['cuty_total'].'<br>
                    <ion-icon name="chatbubble-outline"></ion-icon> '.$row_cuty['cuty_description'].'</p>
              </div>
          </div>
          <div class="right">';
            if($row_cuty['cuty_status']=='3'){
              echo'
             <button type="button" class="btn btn-success btn-sm btn-update-cuty" data-id="'.$row_cuty['cuty_id'].'" data-start="'.tanggal_ind($row_cuty['cuty_start']).'" data-end="'.tanggal_ind($row_cuty['cuty_end']).'" data-work="'.tanggal_ind($row_cuty['date_work']).'" data-total="'.$row_cuty['cuty_total'].'" data-description="'.$row_cuty['cuty_description'].'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
           }
             else{
              echo'<button type="button" class="btn btn-success btn-sm access-failed"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
             }
            echo'
          </div>
      </div>';
      }
    }else{
      echo'';
    }


// -------------- ADD CUTY ----------------------//
break;
case 'add-cuty':
$error = array();

  if (empty($_POST['cuty_start'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_start= date('Y-m-d',strtotime($_POST['cuty_start']));
  }

  if (empty($_POST['cuty_end'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_end= date('Y-m-d',strtotime($_POST['cuty_end']));
  }
  
  /*
  if (empty($_POST['date_work'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $date_work= date('Y-m-d',strtotime($_POST['date_work']));
  }

  if (empty($_POST['cuty_total'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_total = anti_injection($_POST['cuty_total']);
  }
  */
  $date_work = "";

  if (empty($_POST['cuty_description'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_description  = anti_injection($_POST['cuty_description']);
  }
  
  if($cuty_start == $cuty_end){
	$cuty_total = 1;
  }
  else{
	$cuty_total = (((abs(strtotime ($cuty_start) - strtotime ($cuty_end)))/(60*60*24))) + 1;
  }


if (empty($error)) {
  $query="SELECT * FROM cuty WHERE employees_id = '".$row_user[id]."' AND cuty_start = '$cuty_start'";
  $result= $connection->query($query) or die($connection->error.__LINE__);
  if(!$result ->num_rows >0){
    $add ="INSERT INTO cuty (employees_id,
              cuty_start,
              cuty_end,
              date_work,
              cuty_total,
              cuty_description,
              cuty_status) values('$row_user[id]',
              '$cuty_start',
              '$cuty_end',
              '$date_work',
              '$cuty_total',
              '$cuty_description',
              '3')";
    if($connection->query($add) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
    }}
    else   {
      echo'Sepertinya "'.$row_user['employees_name'].'" sudah mengajukan cuti di Tanggal ini!';
    }}

    else{           
        echo'Bidang inputan masih ada yang kosong..!';
    }



// -------------- UPDATE CUTY ----------------------//
break;
case 'update-cuty':
$error = array();
  if (empty($_POST['cuty_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_id = anti_injection($_POST['cuty_id']);
  }

  if (empty($_POST['cuty_start'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_start= date('Y-m-d',strtotime($_POST['cuty_start']));
  }

  if (empty($_POST['cuty_end'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_end= date('Y-m-d',strtotime($_POST['cuty_end']));
  }
  /*
  if (empty($_POST['date_work'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $date_work= date('Y-m-d',strtotime($_POST['date_work']));
  }

  if (empty($_POST['cuty_total'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_total = anti_injection($_POST['cuty_total']);
  }
  */
  $date_work = "";
  if (empty($_POST['cuty_description'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $cuty_description  = anti_injection($_POST['cuty_description']);
  }
  
  if($cuty_start == $cuty_end){
	$cuty_total = 1;
  }
  else{
	$cuty_total = (((abs(strtotime ($cuty_start) - strtotime ($cuty_end)))/(60*60*24))) + 1;
  }

if (empty($error)) {
	$query_status = "select * from cuty where cuty_id='$cuty_id'";
	$result_status = $connection->query($query_status);
    $row_aa= $result_status->fetch_assoc();
	
	$status_cuty = $row_aa['cuty_status'];
	if($status_cuty == "3"){
		$update="UPDATE cuty SET cuty_start='$cuty_start',
				cuty_end='$cuty_end',
				date_work='$date_work',
				cuty_total='$cuty_total',
				cuty_description='$cuty_description' WHERE cuty_id='$cuty_id'"; 
		if($connection->query($update) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}}
		else{           
			echo'Bidang inputan masih ada yang kosong..!';
		}
	}
	else{
		echo'Data Cuti Tidak Bisa Diupdate';
	}



// -------------- UPDATE CUTY ----------------------//
break;
case 'load-home-counter':
  if(isset($_POST['month_filter'])){
      $month_filter = strip_tags($_POST['month_filter']);
      $filter ="MONTH(presence_date) ='$month_filter' AND year(presence_date) = '$year'"; 
    } 
    else{
      $filter ="MONTH(presence_date) ='$month' AND year(presence_date) = '$year'";
  }


  $query_hadir="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND present_id='1' ORDER BY presence_id DESC";
  $hadir= $connection->query($query_hadir);

  $query_sakit="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND present_id='2' ORDER BY presence_id";
  $sakit = $connection->query($query_sakit);

  $query_izin="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND present_id='3' ORDER BY presence_id";
  $izin = $connection->query($query_izin);

  $query_shift ="SELECT time_in,time_out FROM shift WHERE shift_id='$row_user[shift_id]'";
  $result_shift = $connection->query($query_shift);
  $row_shift = $result_shift->fetch_assoc();
  $shift_time_in = $row_shift['time_in'];
  $newtimestamp = strtotime(''.$shift_time_in.' + 05 minute');
  $newtimestamp = date('H:i:s', $newtimestamp);

  $query_telat ="SELECT presence_id FROM presence WHERE employees_id='$row_user[id]' AND $filter AND time_in>shift_time_in";
  $telat = $connection->query($query_telat);

  echo'
  <!-- item -->
  <div class="col-6 col-md-3 mb-2">
      <a href="javascript:void(0)" class="item">
          <div class="detail">
              <div class="icon-block text-primary">
                  <ion-icon name="log-in"></ion-icon>
              </div>
              <div>
                  <strong>Hadir</strong>
                  <p>'.$hadir->num_rows.' Hari</p>
              </div>
          </div>
      </a>
  </div>
  <!-- * item -->
  <!-- item -->
  <div class="col-6 col-md-3 mb-2">
      <a href="javascript:void(0)" class="item">
          <div class="detail">
              <div class="icon-block text-success">
                  <ion-icon name="person"></ion-icon>
              </div>
              <div>
                  <strong>Izin</strong>
                  <p>'.$izin->num_rows.' Hari</p>
              </div>
          </div>
      </a>
  </div>
  <!-- * item -->

  <!-- item -->
  <div class="col-6 col-md-3">
      <a href="javascript:void(0)" class="item">
          <div class="detail">
              <div class="icon-block text-secondary">
                 <ion-icon name="sad"></ion-icon>
              </div>
              <div>
                  <strong>Sakit</strong>
                  <p>'.$sakit->num_rows.' Hari</p>
              </div>
          </div>
      </a>
  </div>
  <!-- * item -->
  <!-- item -->
  <div class="col-6 col-md-3">
      <a href="javascript:void(0)" class="item">
          <div class="detail">
              <div class="icon-block text-danger">
                <ion-icon name="alarm"></ion-icon>
              </div>
              <div>
                  <strong>Terlambat</strong>
                  <p>'.$telat->num_rows.' hari</p>
              </div>
          </div>
      </a>
  </div>
  <!-- * item -->';
    

break;

case 'sppd':
if(isset($_POST['from']) OR isset($_POST['to'])){
      $from = date('Y-m-d', strtotime($_POST['from']));
      $to   = date('Y-m-d', strtotime($_POST['to']));

      $filter ="tgl_awal BETWEEN '$from' AND '$to'";
  } 
  else{
      $filter ="MONTH(tgl_awal) ='$month'";
}

	$query_sppd ="SELECT employees.employees_name,sppd.* FROM employees,sppd WHERE employees.id=sppd.employees_id  AND $filter  AND sppd.employees_id='$row_user[id]' ORDER BY sppd.id_sppd DESC";
    $result_sppd = $connection->query($query_sppd);
    if($result_sppd->num_rows > 0){
      while ($row_sppd = $result_sppd->fetch_assoc()) {
        if($row_sppd['status_sppd']=='2'){
          $status = '<span class="badge badge-success">Disetujui</span>';
        }elseif($row_sppd['status_sppd']=='3'){
          $status = '<span class="badge badge-danger">Tidak disetujui</span>';
        }else{
          $status = '<span class="badge badge-secondary">Blm.Approve</span>';
        }
      echo'
      <div class="item">
          <div class="detail">
              <div>
                  <strong>'.$row_sppd['no_bukti'].' - '.$row_sppd['employees_name'].' '.$status.'</strong>
                  <p><ion-icon name="calendar-outline"></ion-icon> '.tanggal_ind($row_sppd['tgl_awal']).' - '.tanggal_ind($row_sppd['tgl_akhir']).'<br>
                    <ion-icon name="chatbubble-outline"></ion-icon> '.$row_sppd['keterangan'].'</p>
              </div>
          </div>
          <div class="right">';
            if($row_sppd['status_sppd']=='1'){
              echo'
             <button type="button" class="btn btn-success btn-sm btn-update-sppd" data-id="'.$row_sppd['id_sppd'].'" data-start="'.tanggal_ind($row_sppd['tgl_awal']).'" data-end="'.tanggal_ind($row_sppd['tgl_akhir']).'" data-description="'.$row_sppd['keterangan'].'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
           }
             else{
              echo'<button type="button" class="btn btn-success btn-sm access-failed"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
             }
            echo'
          </div>
      </div>';
      }
    }else{
      echo'';
    }
	
// -------------- ADD SPPD ----------------------//
break;
case 'add-sppd':
$error = array();

  if (empty($_POST['tgl_awal'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_awal= date('Y-m-d',strtotime($_POST['tgl_awal']));
  }

  if (empty($_POST['tgl_akhir'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_akhir= date('Y-m-d',strtotime($_POST['tgl_akhir']));
  }

  if (empty($_POST['keterangan'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $keterangan  = anti_injection($_POST['keterangan']);
  }


if (empty($error)) {
  $query="SELECT id_sppd from sppd where tgl_awal ='$tgl_awal' and employees_id='".$row_user[id]."'";
  
  $kd = "SPD";
  $tanggal = $tgl_awal;
  $str = explode("-", $tanggal);
  $thn = $str[0];
  $bln = $str[1];
  $tahun = substr($thn,2,2);
  
  $kode = $kd.$bln.$tahun;
  $sql = "SELECT MAX(no_bukti) AS maxID FROM sppd WHERE no_bukti like '$kode%'";
  $result_spd = $connection->query($sql);
  $row_spd = $result_spd->fetch_assoc();
  $noUrut = (int) substr($row_spd['maxID'], -4);
  $noUrut++;
  $newId = sprintf("%04s", $noUrut);
  $noBukti= $kode.$newId;

  $result= $connection->query($query) or die($connection->error.__LINE__);
  if(!$result ->num_rows >0){
	if($tgl_akhir < $tgl_awal){
		echo'Tgl.Akhir Kurang Dari Tgl.Awal';
	}
	else{
		$add ="INSERT INTO sppd (employees_id,
				  no_bukti,
				  tgl_awal,
				  tgl_akhir,
				  keterangan,
				  status_sppd) values('$row_user[id]',
				  '$noBukti',
				  '$tgl_awal',
				  '$tgl_akhir',
				  '$keterangan',
				  '1')";
		if($connection->query($add) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}
	}
    }
    else   {
      echo'Sepertinya "'.$row_user['employees_name'].'" sudah mengajukan sppd di tanggal ini!';
    }}

    else{           
        echo'Bidang inputan masih ada yang kosong..!';
    }



// -------------- UPDATE SPPD ----------------------//
break;
case 'update-sppd':
$error = array();
  if (empty($_POST['id_sppd'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $id_sppd = anti_injection($_POST['id_sppd']);
  }

  if (empty($_POST['tgl_awal'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_awal= date('Y-m-d',strtotime($_POST['tgl_awal']));
  }

  if (empty($_POST['tgl_akhir'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_akhir= date('Y-m-d',strtotime($_POST['tgl_akhir']));
  }

  if (empty($_POST['keterangan'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $keterangan  = anti_injection($_POST['keterangan']);
  }

if (empty($error)) {
	if($tgl_akhir < $tgl_awal){
		echo'Tgl.Akhir Kurang Dari Tgl.Awal';
	}
	else{
		$update="UPDATE sppd SET tgl_awal='$tgl_awal',
				tgl_akhir='$tgl_akhir',
				keterangan='$keterangan' WHERE id_sppd='$id_sppd'"; 
		if($connection->query($update) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}
	}
}
else{           
	echo'Bidang inputan masih ada yang kosong !';
}

// -------------- UPDATE sppd ----------------------//
break;


case 'izin':
if(isset($_POST['from']) OR isset($_POST['to'])){
      $from = date('Y-m-d', strtotime($_POST['from']));
      $to   = date('Y-m-d', strtotime($_POST['to']));

      $filter ="tgl_awal BETWEEN '$from' AND '$to'";
  } 
  else{
      $filter ="MONTH(tgl_awal) ='$month'";
}

	$query_sppd ="SELECT employees.employees_name,izin.* FROM employees,izin WHERE employees.id=izin.employees_id  AND $filter  AND izin.employees_id='$row_user[id]' ORDER BY izin.id_izin DESC";
    $result_sppd = $connection->query($query_sppd);
    if($result_sppd->num_rows > 0){
      while ($row_sppd = $result_sppd->fetch_assoc()) {
        if($row_sppd['status_izin']=='2'){
          $status = '<span class="badge badge-success">Disetujui</span>';
        }elseif($row_sppd['status_izin']=='3'){
          $status = '<span class="badge badge-danger">Tidak disetujui</span>';
        }else{
          $status = '<span class="badge badge-secondary">Blm.Approve</span>';
        }
      echo'
      <div class="item">
          <div class="detail">
              <div>
                  <strong>'.$row_sppd['no_bukti'].' - '.$row_sppd['employees_name'].' '.$status.'</strong>
                  <p><ion-icon name="calendar-outline"></ion-icon> '.tanggal_ind($row_sppd['tgl_awal']).' - '.tanggal_ind($row_sppd['tgl_akhir']).'<br>
                    <ion-icon name="chatbubble-outline"></ion-icon> '.$row_sppd['keterangan'].'</p>
              </div>
          </div>
          <div class="right">';
            if($row_sppd['status_izin']=='1'){
              echo'
             <button type="button" class="btn btn-success btn-sm btn-update-izin" data-id="'.$row_sppd['id_izin'].'" data-start="'.tanggal_ind($row_sppd['tgl_awal']).'" data-end="'.tanggal_ind($row_sppd['tgl_akhir']).'" data-description="'.$row_sppd['keterangan'].'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
           }
             else{
              echo'<button type="button" class="btn btn-success btn-sm access-failed"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
             }
            echo'
          </div>
      </div>';
      }
    }else{
      echo'';
    }
	
// -------------- ADD SPPD ----------------------//
break;
case 'add-izin':
$error = array();

  if (empty($_POST['tgl_awal'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_awal= date('Y-m-d',strtotime($_POST['tgl_awal']));
  }

  if (empty($_POST['tgl_akhir'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_akhir= date('Y-m-d',strtotime($_POST['tgl_akhir']));
  }

  if (empty($_POST['keterangan'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $keterangan  = anti_injection($_POST['keterangan']);
  }


if (empty($error)) {
  $query="SELECT id_izin from izin where tgl_awal ='$tgl_awal' and employees_id='".$row_user[id]."'";
  
  $kd = "IZ";
  $tanggal = $tgl_awal;
  $str = explode("-", $tanggal);
  $thn = $str[0];
  $bln = $str[1];
  $tahun = substr($thn,2,2);
  
  $kode = $kd.$bln.$tahun;
  $sql = "SELECT MAX(no_bukti) AS maxID FROM izin WHERE no_bukti like '$kode%'";
  $result_spd = $connection->query($sql);
  $row_spd = $result_spd->fetch_assoc();
  $noUrut = (int) substr($row_spd['maxID'], -4);
  $noUrut++;
  $newId = sprintf("%04s", $noUrut);
  $noBukti= $kode.$newId;

  $result= $connection->query($query) or die($connection->error.__LINE__);
  if(!$result ->num_rows >0){
	if($tgl_akhir < $tgl_awal){
		echo'Tgl.Akhir Kurang Dari Tgl.Awal';
	}
	else{
		$add ="INSERT INTO izin (employees_id,
				  no_bukti,
				  tgl_awal,
				  tgl_akhir,
				  keterangan,
				  status_izin) values('$row_user[id]',
				  '$noBukti',
				  '$tgl_awal',
				  '$tgl_akhir',
				  '$keterangan',
				  '1')";
		if($connection->query($add) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}
	}
    }
    else   {
      echo'Sepertinya "'.$row_user['employees_name'].'" sudah mengajukan izin di tanggal ini!';
    }}

    else{           
        echo'Bidang inputan masih ada yang kosong..!';
    }



// -------------- UPDATE IZIN ----------------------//
break;
case 'update-izin':
$error = array();
  if (empty($_POST['id_izin'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $id_izin = anti_injection($_POST['id_izin']);
  }

  if (empty($_POST['tgl_awal'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_awal= date('Y-m-d',strtotime($_POST['tgl_awal']));
  }

  if (empty($_POST['tgl_akhir'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_akhir= date('Y-m-d',strtotime($_POST['tgl_akhir']));
  }

  if (empty($_POST['keterangan'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $keterangan  = anti_injection($_POST['keterangan']);
  }

if (empty($error)) {
	if($tgl_akhir < $tgl_awal){
		echo'Tgl.Akhir Kurang Dari Tgl.Awal';
	}
	else{
		$update="UPDATE izin SET tgl_awal='$tgl_awal',
				tgl_akhir='$tgl_akhir',
				keterangan='$keterangan' WHERE id_izin='$id_izin'"; 
		if($connection->query($update) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}
	}
}
else{           
	echo'Bidang inputan masih ada yang kosong !';
}

// -------------- UPDATE izin ----------------------//
break;

case 'job':
if(isset($_POST['from']) OR isset($_POST['to'])){
      $from = date('Y-m-d', strtotime($_POST['from']));
      $to   = date('Y-m-d', strtotime($_POST['to']));

      $filter ="tgl_job BETWEEN '$from' AND '$to'";
  } 
  else{
      $filter ="MONTH(tgl_job) ='$month'";
}

$query_job ="SELECT employees.employees_name,job.* FROM employees,job WHERE employees.id=job.employees_id  AND $filter  AND job.employees_id='$row_user[id]' ORDER BY job.job_id DESC";
    $result_job = $connection->query($query_job);
    if($result_job->num_rows > 0){
      while ($row_job = $result_job->fetch_assoc()) {
        
      echo'
      <div class="item">
          <div class="detail">
              <div>
                  <strong>'.$row_job['employees_name'].' </strong>
                  <p><ion-icon name="calendar-outline"></ion-icon> '.tanggal_ind($row_job['tgl_job']).', <ion-icon name="alarm-outline"></ion-icon> '.$row_job['jam_start'].' - '.$row_job['jam_end'].'<br><ion-icon name="bookmarks-outline"></ion-icon> Sifat : '.$row_job['sifat'].', <ion-icon name="battery-half-outline"></ion-icon> Persentase : '.$row_job['persentase'].' % <br>
                    <ion-icon name="chatbubble-outline"></ion-icon> '.$row_job['job'].'</p>
              </div>
          </div>
          <div class="right">';
            if($row_job['job_id']>'0'){
              echo'
             <button type="button" class="btn btn-success btn-sm btn-update-job" data-id="'.$row_job['job_id'].'" data-tgl_job="'.tanggal_ind($row_job['tgl_job']).'" data-jam_start="'.$row_job['jam_start'].'" data-jam_end="'.$row_job['jam_end'].'" data-persentase="'.$row_job['persentase'].'" data-sifat="'.$row_job['sifat'].'" data-description="'.$row_job['job'].'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';

             echo'
             <button type="button" class="btn btn-danger btn-sm btn-delete-job" data-id="'.$row_job['job_id'].'" ><i class="fas fa-trash-alt" aria-hidden="true"></i></button>';
           }
             else{
              echo'<button type="button" class="btn btn-success btn-sm access-failed"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>';
             }
            echo'
          </div>
      </div>';
      }
    }else{
      echo'';
    }


// -------------- ADD job ----------------------//
break;
case 'add-job':
$error = array();

  if (empty($_POST['sifat'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $sifat= $_POST['sifat'];
  }

  if (empty($_POST['tgl_job'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_job= date('Y-m-d',strtotime($_POST['tgl_job']));
  }

  if (empty($_POST['jam_start'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $jam_start= $_POST['jam_start'];
  }

  if (empty($_POST['jam_end'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $jam_end= $_POST['jam_end'];
  }
  
 if (empty($_POST['job'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $job  = anti_injection($_POST['job']);
  }

  if (empty($_POST['persentase'])) {
      $error[] = 'tidak boleh kosong';
    } else {

      $nilai  = $_POST['persentase'];
      if ($nilai >= 1 && $nilai <= 100) {
          $persentase  = $nilai;
      } else {
          $error[] = 'Nilai harus pada range 1 - 100';
      }
      
  }
  
 
if (empty($error)) {
  
      $add ="INSERT INTO job (employees_id,
                tgl_job,
                jam_start,
                jam_end,
                job,
                persentase,
                sifat,
                tgl_input) values(
                '$row_user[id]',
                '$tgl_job',
                '$jam_start',
                '$jam_end',
                '$job',
                '$persentase',
                '$sifat',
                NOW())";

        if($connection->query($add) === false) { 
            die($connection->error.__LINE__); 
            echo'Data tidak berhasil disimpan!';
        } else{
            echo'success';
        }
    

  }else{           
      echo'Bidang inputan masih ada yang kosong..!';
  }



// -------------- UPDATE CUTY ----------------------//
break;
case 'update-job':
$error = array();
  if (empty($_POST['job_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $job_id = anti_injection($_POST['job_id']);
  }

  if (empty($_POST['tgl_job'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tgl_job= date('Y-m-d',strtotime($_POST['tgl_job']));
  }

  if (empty($_POST['jam_start'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $jam_start= $_POST['jam_start'];
  }

  if (empty($_POST['jam_end'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $jam_end= $_POST['jam_end'];
  }

  if (empty($_POST['persentase'])) {
      $error[] = 'tidak boleh kosong';
    } else {

      $nilai  = $_POST['persentase'];
      if ($nilai >= 1 && $nilai <= 100) {
          $persentase  = $nilai;
      } else {
          $error[] = 'Nilai harus pada range 1 - 100';
      }
      
  }

  if (empty($_POST['job'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $job= $_POST['job'];
  }

  if (empty($_POST['sifat'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $sifat= $_POST['sifat'];
  }

if (empty($error)) {
  $query_status = "select * from job where job_id='$job_id'";
  $result_status = $connection->query($query_status);
    $row_aa= $result_status->fetch_assoc();
  	
  	$update="UPDATE job SET tgl_job='$tgl_job',
        jam_start='$jam_start',
        jam_end='$jam_end',
        job='$job',
        persentase='$persentase',
        sifat='$sifat'
        WHERE job_id='$job_id'"; 
    if($connection->query($update) === false) { 
      die($connection->error.__LINE__); 
      echo'Data tidak berhasil disimpan!';
    } else{
      echo'success';
    }
  }
  else{
    echo'Data Pekerjaan Tidak Bisa Diupdate';
  }

break;
case 'delete-job':
$error = array();
  if (empty($_GET['job_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $job_id = $_GET['job_id'];
  }

  
if (empty($error)) {
  
  	$update="DELETE FROM job 
        WHERE job_id='$job_id'"; 
    if($connection->query($update) === false) { 
      die($connection->error.__LINE__); 
      echo'Data tidak berhasil disimpan!';
    } else{
      echo'success';
    }
  }
  else{
  	//echo $job_id;
    echo'Data Pekerjaan Tidak Bisa Dihapus';
  }


// -------------- UPDATE CUTY ----------------------//
}?>