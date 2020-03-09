<?php

$dfh = fopen('2018-directory.csv', 'r');
$header = fgetcsv($dfh);
fgetcsv($dfh);
fgetcsv($dfh);
$directory = [];
while ($row_data = fgetcsv($dfh)) {
  $row = array_combine($header, $row_data);
  // print_r($row); break;
  $dir_info = [
    'cell' => $row['Cell Phone #'],
    'email' => $row['Email Address'],
    'parents' => $row['Parents'],
    'parents_phone' => $row['Parents Phone #'],
    'parents_email' => $row['Parent Email Address'],
  ];
  $bits = [];
  $fname = strtolower(trim($row['FirstName']));
  if ($row['GoesBy']) {
    $fname = strtolower(trim($row['GoesBy']));
  }
  $bits[] = $fname;
  $bits[] = strtolower(trim($row['LastName']));
  $bits[] = strtotime(trim($row['DateOfBirth']));
  $key = implode('-=-', $bits);
  $directory[$key] = $dir_info;
}
fclose($dfh);

$dfh = fopen('2019-directory.csv', 'r');
$header = fgetcsv($dfh);
while ($row_data = fgetcsv($dfh)) {
  $row = array_combine($header, $row_data);
  // print_r($row); break;
  $dir_info = [
    'cell' => $row['Cell Phone'],
    'email' => $row['Email Address'],
    'parents' => $row['Parent Names'],
    'parents_phone' => $row['Parent Cell'],
    'parents_email' => $row['Parent Email Address'],
  ];
  $bits = [];
  $bits[] = strtolower(trim($row['First Name']));
  $bits[] = strtolower(trim($row['Last Name']));
  $bits[] = strtotime(trim($row['Birthdate']));
  $key = implode('-=-', $bits);
  if (!isset($directory[$key])) {
    $directory[$key] = $dir_info;
  }
}
fclose($dfh);

// print_r($directory);

$fh = fopen('youth-attendance.csv', 'r');
$ofh = fopen('output.csv', 'w');
$header = fgetcsv($fh);
$output_headers = ['first', 'last', 'dob', 'age', 'grade', 'gender', 'attended', 'total', 'miss_count', 'cell', 'email', 'parents', 'parents_phone', 'parents_email'];
fputcsv($ofh, $output_headers);
// Trim off everything after #69
$header = array_slice($header, 0, 69);
// print_r($header);
$now = time();

while ($row_data = fgetcsv($fh)) {
  $row_data = array_slice($row_data, 0, 69);
  $row = array_combine($header, $row_data);
  $data_row = [
    'first' => $row['FirstName'],
    'last' => $row['LastName'],
    'dob' => $row['DateOfBirth'],
    'age' => $row['Age'],
    'grade' => $row['Grade'],
    'gender' => $row['Gender'],
    'attended' => 0,
    'total' => 0,
    'miss_count' => 0,
    'cell' => '',
    'email' => '',
    'parents' => '',
    'parents_phone' => '',
    'parents_email' => '',
  ];
  if (preg_match('/^[A-Z]/', $row['FirstName']) && $row['Sunday Night Youth'] == 'YES') {
    foreach ($row as $key => $val) {
      if (preg_match('%^\d+/\d+/\d+$%', $key)) {
        $epoch = strtotime($key);
        if ($epoch < $now) {
          $data_row['total']++;
          if ($val) {
            $data_row['attended']++;
            $data_row['miss_count'] = 0;
          }
          else {
            $data_row['miss_count']++;
          }
        }
      }
    }
    $bits = [];
    $bits[] = strtolower(trim($row['FirstName']));
    $bits[] = strtolower(trim($row['LastName']));
    $bits[] = strtotime(trim($row['DateOfBirth']));
    $key = implode('-=-', $bits);
    if (isset($directory[$key])) {
      foreach ($directory[$key] as $key => $val) {
        $data_row[$key] = $val;
      }
    }
    // print_r($row); print_r($data_row); print_r($key);
    $csv_row = [];
    foreach ($output_headers as $oHeader) {
      $csv_row[] = $data_row[$oHeader];
    }
    fputcsv($ofh, $csv_row);
  }
}

fclose($fh);
fclose($ofh);

echo "All done!\n";
