IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Login_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_Login_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_Login_ACT1 '809', '123', N'', 'Login', '::1'
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Check account login
--*  
--*  作成日/create date			:	2024/02/16
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_Login_ACT1
	@P_user_cd						NVARCHAR(50)	= N''
,	@P_password						NVARCHAR(50)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
		@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Insert'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	IF NOT EXISTS (
		SELECT
			1
		FROM M002
		WHERE
			M002.user_cd			= @P_user_cd
		AND M002.[password]			= @P_password
		AND M002.del_flg			= 0
	)
	BEGIN
		INSERT INTO @ERR_TBL
		SELECT
			'E008'
		,	N''
		,	0
		,	1
		,	0
		,	N''
		,	N''
		SET @w_prs_result = N'NG'
		SET @w_remarks = N'IDとパスワードを確認してください。'
	END

	EXEC SPC_S999_ACT1
		@P_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	N''
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL
	SELECT TOP 1
		M002.user_cd
	,	M002.user_nm
	,	M002.user_kn_nm
	,	M002.user_ab_nm
	,	M002.tel
	,	M002.fax
	,	M002.mailaddress
	,	M002.belong_department_div
	,	belong_department.[name]	AS 	belong_department_nm
	,	M002.authority_div
	,	authority.[name]			AS 	authority_nm
	,	M002.remarks
	FROM M002 WITH(NOLOCK)
	LEFT JOIN M401					AS belong_department WITH(NOLOCK)	ON (
		belong_department.name_div	= 'belong_department_div'
	AND belong_department.name_cd	= M002.belong_department_div
	)
	LEFT JOIN M401					AS authority WITH(NOLOCK)			ON (
		authority.name_div			= 'authority_div'
	AND authority.name_cd			= M002.authority_div
	)
	WHERE
		M002.user_cd				= @P_user_cd
	AND M002.[password]				= @P_password
	AND M002.del_flg				<> 1
END
GO
