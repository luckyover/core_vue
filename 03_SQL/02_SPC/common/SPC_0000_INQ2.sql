IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_0000_INQ2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_0000_INQ2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_0000_INQ2 '809', '', 'Login', '::1'
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
CREATE PROCEDURE SPC_0000_INQ2
	@P_user_cd						NVARCHAR(50)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;

	CREATE TABLE #S003_TMP (
		prg_cd						NVARCHAR(50)
	,	fnc_cd						NVARCHAR(50)
	,	fnc_nm						NVARCHAR(50)
	,	fnc_use_div					SMALLINT
	)
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
	FROM M002 WITH(NOLOCK)
	LEFT JOIN M401					AS belong_department WITH(NOLOCK)	ON (
		belong_department.name_div	= N'belong_department_div'
	AND belong_department.name_cd	= M002.belong_department_div
	)
	LEFT JOIN M401					AS authority WITH(NOLOCK)			ON (
		authority.name_div			= N'authority_div'
	AND authority.name_cd			= M002.authority_div
	)
	WHERE
		M002.user_cd				= @P_user_cd
	AND M002.del_flg				<> 1

	SELECT
		S003.prg_cd
	,	S003.fnc_cd
	,	S003.fnc_nm
	,	MAX(ISNULL(S004.fnc_use_div, 0))		 AS fnc_use_div
	FROM S003						WITH(NOLOCK)
	LEFT JOIN M002					WITH(NOLOCK) ON (
		M002.user_cd				= @P_user_cd
	AND M002.del_flg				<> 1
	)
	LEFT JOIN S002					WITH(NOLOCK) ON (
		S002.prg_cd					= S003.prg_cd
	AND S002.del_flg				<> 1
	)
	LEFT JOIN S004					 WITH(NOLOCK) ON (
		S003.prg_cd					= S004.prg_cd
	AND S003.fnc_cd					= S004.fnc_cd
	AND S004.auth_role_div			= M002.authority_div
	AND S004.del_flg				<> 1
	)
	WHERE
		S003.del_flg				<> 1
	AND S002.prg_cd					IS NOT NULL
	GROUP BY
		S003.prg_cd
	,	S003.fnc_cd
	,	S003.fnc_nm

	DROP TABLE IF EXISTS #S003_TMP
END
GO
