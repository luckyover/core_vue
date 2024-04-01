IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M001_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M001_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M001_INQ1
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Insert or update data for user
--*  
--*  作成日/create date			:	2024/02/17
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M001_INQ1
	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT
		M001.company_cd
	,	M001.company_nm1 AS company_nm
	FROM M001 WITH(NOLOCK)
	WHERE
			M001.del_flg <> 1
END
GO