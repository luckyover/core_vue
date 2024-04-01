IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M401_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M401_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M401_INQ1 'belong_department_div', '1', '809', 'M002', '::1'
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get library follow div
--*  
--*  作成日/create date			:	2024/02/17
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M401_INQ1
	@P_name_div						NVARCHAR(50)	= N''
,	@P_add_empty					BIT				= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	IF @P_add_empty = 1
	BEGIN
		SELECT
			@P_name_div						AS name_div
		,	0								AS name_cd
		,	N''								AS [name]
		,	N''								AS kn_name
		,	N''								AS ab_name
		,	NULL							AS char_remakrs_ex1
		,	NULL							AS char_remakrs1
		,	NULL							AS char_remakrs_ex2
		,	NULL							AS char_remakrs2
		,	NULL							AS num_remakrs_ex1
		,	NULL							AS num_remakrs1
		,	NULL							AS num_remakrs_ex2
		,	NULL							AS num_remakrs2
		,	0								AS default_flg
		,	0								AS sort
		UNION ALL
		SELECT
			M401.name_div
		,	M401.name_cd
		,	M401.[name]
		,	M401.kn_name
		,	M401.ab_name
		,	M401.char_remakrs_ex1
		,	M401.char_remakrs1
		,	M401.char_remakrs_ex2
		,	M401.char_remakrs2
		,	M401.num_remakrs_ex1
		,	M401.num_remakrs1
		,	M401.num_remakrs_ex2
		,	M401.num_remakrs2
		,	M401.default_flg
		,	M401.sort						AS sort
		FROM M401 WITH(NOLOCK)
		WHERE
			M401.name_div					= @P_name_div
		AND M401.del_flg					<> 1
		ORDER BY sort ASC
	END
	ELSE
	BEGIN
		SELECT
			M401.name_div
		,	M401.name_cd
		,	M401.[name]
		,	M401.kn_name
		,	M401.ab_name
		,	M401.char_remakrs_ex1
		,	M401.char_remakrs1
		,	M401.char_remakrs_ex2
		,	M401.char_remakrs2
		,	M401.num_remakrs_ex1
		,	M401.num_remakrs1
		,	M401.num_remakrs_ex2
		,	M401.num_remakrs2
		,	M401.default_flg
		,	M401.sort
		FROM M401 WITH(NOLOCK)
		WHERE
			M401.name_div					= @P_name_div
		AND M401.del_flg					<> 1
		ORDER BY M401.sort ASC
	END
END
GO
