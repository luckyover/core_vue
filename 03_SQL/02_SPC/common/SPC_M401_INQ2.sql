IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M401_INQ2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M401_INQ2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M401_INQ2 'belong_department_div,authority_div', '809', 'M002', '::1'
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get library follow many div
--*  
--*  作成日/create date			:	2024/02/20
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M401_INQ2
	@P_name_div						NVARCHAR(MAX)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
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
		M401.name_div					IN (
			SELECT
				[value]
			FROM STRING_SPLIT(@P_name_div, ',')
		)
	AND M401.del_flg					<> 1
	ORDER BY
		M401.name_div ASC
	,	M401.sort ASC
END
GO
