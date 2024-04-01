IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M102_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M102_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M102_INQ1 'ITEM1','','809','M101','172.19.0.1';
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get data sizes of product
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M102_INQ1
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_color_cd						NVARCHAR(10)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SET @P_color_cd = ISNULL(@P_color_cd, N'')
	SELECT
		M102.item_cd
	,	M102.color_cd
	,	M102.size_cd
	,	M102.discontinued_div
	,	M102.discontinued_display_div
	,	M102.sort_div
	FROM M102 WITH(NOLOCK)
	WHERE
		M102.item_cd					= @P_item_cd
	AND M102.color_cd					= @P_color_cd
	AND M102.del_flg					<> 1
	ORDER BY
		M102.sort_div
END
GO
