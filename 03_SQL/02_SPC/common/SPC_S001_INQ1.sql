IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S001_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_S001_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_S001_INQ1 'F001', @w_number OUT, @P_act_user_cd, @P_prg, @P_ip
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get id for new record follow table
--*  
--*  作成日/create date			:	2024/02/17
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE [dbo].[SPC_S001_INQ1]
	@P_classify_cd					NVARCHAR(50)	= N''
,	@P_serial_no					NVARCHAR(50)	= N''	OUTPUT
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
        @w_ErrorMessage				NVARCHAR(4000)	= N''
    ,   @w_ErrorSeverity			INT				= 11
    ,   @w_ErrorState				INT				= 1
	,	@w_no_classify_cd			NVARCHAR(10)	= N''
	,	@w_start_number				BIGINT			= 0
	,	@w_finish_number			BIGINT			= 0
	,	@w_serial_no				BIGINT			= 0
	,	@w_no_prefix_char			NVARCHAR(3)		= N''
	,	@w_no_digit					NVARCHAR(3)		= 0
	,	@w_time						DATETIME2		= SYSDATETIME()

	SELECT TOP 1
		@w_no_classify_cd		= no_classify_cd
	,	@w_start_number			= ISNULL(start_number, 0)
	,	@w_finish_number		= ISNULL(finish_number, 0)
	,	@w_no_prefix_char		= ISNULL(IIF(no_prefix_char = 'yy', FORMAT(@w_time, 'yy'), no_prefix_char), '')
	,	@w_serial_no			= ISNULL(serial_no, 0) + 1
	,	@w_no_digit				= ISNULL(no_digit, 0) - LEN(ISNULL(no_prefix_char, ''))
	FROM S001 WITH(NOLOCK)
	WHERE
		no_classify_cd				= @P_classify_cd
	AND del_flg						<> 1

	IF @w_no_classify_cd = ''
	BEGIN
		SET @w_ErrorMessage		= N'対象となる発番CD[' + @P_classify_cd + ']が存在しません。'
		RAISERROR(@w_ErrorMessage, @w_ErrorSeverity, @w_ErrorState)
	END

	IF @w_no_digit < 1
	BEGIN
		SET @w_ErrorMessage		= N'パラメータが不正の為、自動発番出来ません。'
		RAISERROR(@w_ErrorMessage, @w_ErrorSeverity, @w_ErrorState)
	END

	IF @w_serial_no > @w_finish_number
	BEGIN
		SET @w_ErrorMessage		= N'発番番号が終了番号[' + CONVERT(NVARCHAR(50), @w_finish_number) + ']超過です。'
		RAISERROR(@w_ErrorMessage, @w_ErrorSeverity, @w_ErrorState)
	END

	IF @w_start_number > @w_serial_no
	BEGIN
		SET @w_serial_no = @w_start_number
	END

	UPDATE S001
	SET
		serial_no			= @w_serial_no
	,	upd_user_cd			= @P_act_user_cd
	,	upd_prg				= @P_prg
	,	upd_ip				= @P_ip
	,	upd_tm				= @w_time
	WHERE
		no_classify_cd		= @w_no_classify_cd

	SELECT @P_serial_no = @w_no_prefix_char + RIGHT('0000000000000000000000' + CONVERT(NVARCHAR(50), @w_serial_no), @w_no_digit)
END
