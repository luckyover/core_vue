IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M002_INQ3]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M002_INQ3
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M002_INQ3 '','20','809','M101','172.19.0.1';
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Get list data users for suggest search
--*  
--*  作成日/create date			:	2024/02/26
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M002_INQ3
	@P_search						NVARCHAR(MAX)   = N''
,	@P_rows							INT				= 20
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP (@P_rows)
		M002.user_cd				AS code
	,   M002.user_nm				AS [name]
	FROM M002 WITH(NOLOCK)
	WHERE (
		@P_search					= ''
	OR	M002.user_cd				LIKE '%' + @P_search + '%'
	OR	M002.user_nm				LIKE '%' + @P_search + '%'
	OR	M002.user_kn_nm				LIKE '%' + @P_search + '%'
	OR	M002.user_ab_nm				LIKE '%' + @P_search + '%'
	)
	AND M002.del_flg					<> 1
END
GO
