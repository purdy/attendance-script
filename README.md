# Youth Missing Report Generator

This is a simple utility script to tie together data from a couple of directories and then the overall *People* sheet from the *2019-2020 Youth Directory* Google Sheet.

To run the program, you need to download this repo:
 * Use Terminal and type: `git clone git@github.com:purdy/attendance-script.git`. This will create a folder in your Home folder called attendance-script and that is where all the fun will happen. You can then `cd` into that folder and proceed with the CSV file steps below.
 * If you cannot get git running, you can also download this repo as a ZIP file and then un-ZIP it wherever you'd like. Then you can open up Terminal and `cd` into the folder you setup and proceed with the CSV file steps below.

Then you will need to setup some CSV files:

 * 2018-directory.csv: Once you have this file setup, you probably will never need to update it again. You go to the *2018-2019 Youth Directory* Google Sheet and select the *People* sheet at the bottom and then select *Download* and then *Comma Separated Values (.csv, current sheet)*. That will download the .csv file and you will need to move it into place, wherever you setup this repo. Note that the Download feature from Google Sheets uses the overall sheet title for the file name, so the command to move it into place would look something like this: `mv ~/Downloads/2018-2019\ Youth\ Directory.csv ./2018-directory.csv`.
 * 2019-directory.csv: Once you have this file setup, you probably will never need to update it again (unless there are any changes to the Student Info Form Data Collection sheet). You go to the *2019-2020 Youth Directory* Google Sheet and select the *Student Info Form Data Collection* sheet at the bottom and then select *Download* and then *Comma Separated Values (.csv, current sheet)*. That will download the .csv file and you will need to move it into place, wherever you setup this repo. Note that the Download feature from Google Sheets uses the overall sheet title for the file name, so the command to move it into place would look something like this: `mv ~/Downloads/2019-2020\ Youth\ Directory.csv ./2019-directory.csv`.
 * youth-attendance.csv: This is the file that changes every week. You go to the *2019-2020 Youth Directory* Google Sheet and select the *People* sheet at the bottom and then select *Download* and then *Comma Separated Values (.csv, current sheet)*. That will download the .csv file and you will need to move it into place, wherever you setup this repo. Note that the Download feature from Google Sheets uses the overall sheet title for the file name, so the command to move it into place would look something like this: `mv ~/Downloads/2019-2020\ Youth\ Directory.csv ./youth-attendance.csv`.

Now that you have the CSV files in place, you can run this command inside Terminal inside the repo folder you setup:

    ./build-report.php
 
 It will generate an output.csv file that you can upload to Google Sheets and then sort by the `miss_count`, `grade`, and `gender` columns.
 
 Then the idea is that you just need to re-download and setup the `youth-attendance.csv` file every week after the attendance has been recorded to generate the new report.
