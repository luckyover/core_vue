IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S999_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_S999_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_S999_ACT1 '809', 'M002', 'Update', 'user_cd=809', 'OK', ''
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Save log action
--*  
--*  作成日/create date			:	2024/02/17
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_S999_ACT1
	@P_user_cd						NVARCHAR(5)		= N''
,	@P_prg_id						NVARCHAR(50)	= N''
,	@P_prg_mode						NVARCHAR(10)	= N''
,	@P_prg_key						NVARCHAR(MAX)	= N''
,	@P_result						NVARCHAR(20)	= N''
,	@P_remarks						NVARCHAR(200)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_prg_nm					NVARCHAR(50)	= N''

	SELECT TOP 1
		@w_prg_nm	= prg_nm
	FROM S002 WITH(NOLOCK)
	WHERE
		prg_cd		= @P_prg_id

	INSERT INTO S999
	SELECT
		@P_user_cd
	,	SYSDATETIME()
	,	@P_prg_id
	,	@w_prg_nm
	,	@P_prg_mode
	,	@P_prg_key
	,	@P_result
	,	@P_remarks

END
GO
