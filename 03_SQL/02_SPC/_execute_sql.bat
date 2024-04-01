@ECHO OFF
::データベース情報 -> 簡単に変更できるように変数で設定
SET DB_SERVER=192.168.5.223\SQL2019,2019
SET USER_ID=sparkle
SET USER_PW=Ans@123
SET DB_NAME=SPARKLE_TEST
SET SCHEMA=dbo
::
::sqlcmd.exe が利用可能か判断
FOR %%I IN (sqlcmd.exe) DO (
    ::%%~$PATH:I が空文字 -> 実行不可能
    IF _%%~$PATH:I == _ (
        ECHO [!] Cannot find sqlcmd.exe!!
        GOTO EXIT_BAT
    )
)
ECHO SERVER  : %DB_SERVER%
ECHO USER_ID : %USER_ID%
ECHO DB_NAME : %DB_NAME%
ECHO;
::実行確認
SET /p KEY="Excute ? (y/n)  : %KEY%"
ECHO;
IF %KEY%==y (
	SET FLAG=t
) ELSE IF %KEY%==Y (
	SET FLAG=t
) else (
	SET FLAG=f
)
IF %FLAG%==f (
	ECHO Canceled...
	GOTO EXIT_BAT
)
::バッチのディレクトリへ移動 -> バッチファイルの内のファイルを操作
CD /d %~dp0
::ログ用ディレクトリ作成
ECHO;
ECHO Create directory for log files...
SET TIME=%time: =0%
SET DIR=_log_%date:~-10,4%%date:~-5,2%%date:~-2,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%
MD %DIR%
::
SET ME=%~d0%~p0
::フォルダ階層作成
FOR /R %%I IN (*.sql) DO (
	CALL :SUB_DIR %%I
)
::
ECHO;
ECHO Execute SQL...
ECHO;
::SQL ファイル実行
FOR /R %%I IN (*.sql) DO (
    CALL :SUB_SQL %%I
)
GOTO EXIT_BAT
::
::フォルダ階層作成
:SUB_DIR
	SET PARENT=%~d1%~p1
	CALL SET FOLDER=%%PARENT:%ME%=%%
	IF NOT EXIST %DIR%\%FOLDER% (
		MD %DIR%\%FOLDER%
	)
	EXIT /b
::
::SQL 実行
:SUB_SQL
	SET PARENT=%~d1%~p1
	CALL SET FOLDER=%%PARENT:%ME%=%%
	sqlcmd -S "%DB_SERVER%" -U "%USER_ID%" -P "%USER_PW%" -d "%DB_NAME%" -i "%~d1%~p1%~n1%~x1" -o "%DIR%\%FOLDER%%~n1.log"
	ECHO %~n1%~x1
	EXIT /b
::
:EXIT_BAT
ECHO;
ECHO Program terminated...
ECHO;
PAUSE
